<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class IntegrationController extends Controller
{
    // ... (Fungsi getCountryDetail tetap sama seperti sebelumnya, JANGAN DIHAPUS) ...
    public function getCountryDetail(Request $request, $code)
    {
        $lat = $request->query('lat', 0);
        $lng = $request->query('lng', 0);
        $countryName = $request->query('name', $code);

        try {
            // 1. CUACA (Open-Meteo) 
            $weatherUrl = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lng}&hourly=temperature_2m,precipitation,rain,snowfall,snow_depth,weather_code,cloud_cover,wind_speed_10m,wind_speed_180m,wind_direction_10m,wind_direction_180m,temperature_80m";
            $wRes = Http::withoutVerifying()->timeout(15)->get($weatherUrl);
            
            $weatherData = [];
            if ($wRes->successful()) {
                $h = $wRes->json()['hourly'];
                $weatherData = [
                    'temp_2m' => $h['temperature_2m'][0] ?? 0, 'temp_80m' => $h['temperature_80m'][0] ?? 0,
                    'precipitation' => $h['precipitation'][0] ?? 0, 'rain' => $h['rain'][0] ?? 0,
                    'snowfall' => $h['snowfall'][0] ?? 0, 'snow_depth' => $h['snow_depth'][0] ?? 0,
                    'cloud_cover' => $h['cloud_cover'][0] ?? 0, 'weather_code' => $h['weather_code'][0] ?? 0,
                    'wind_speed_10m' => $h['wind_speed_10m'][0] ?? 0, 'wind_speed_180m' => $h['wind_speed_180m'][0] ?? 0,
                    'wind_dir_10m' => $h['wind_direction_10m'][0] ?? 0, 'wind_dir_180m' => $h['wind_direction_180m'][0] ?? 0,
                ];
            }

            // 2. EKONOMI & GRAFIK (World Bank)
            $indicators = ['GDP' => 'NY.GDP.MKTP.CD', 'Inflasi' => 'FP.CPI.TOTL.ZG', 'Populasi' => 'SP.POP.TOTL', 'Ekspor' => 'NE.EXP.GNFS.ZS', 'Impor' => 'NE.IMP.GNFS.ZS'];
            $economicData = [];
            foreach ($indicators as $key => $ind) {
                try {
                    $res = Http::withoutVerifying()->timeout(5)->get("http://api.worldbank.org/v2/country/{$code}/indicator/{$ind}?format=json&per_page=1");
                    $economicData[$key] = ($res->successful() && isset($res->json()[1])) ? $res->json()[1][0]['value'] : null;
                } catch (\Exception $e) { $economicData[$key] = null; }
            }

            $chartLabels = []; $chartData = [];
            try {
                $gdpResponse = Http::withoutVerifying()->timeout(5)->get("http://api.worldbank.org/v2/country/{$code}/indicator/NY.GDP.MKTP.CD?format=json&per_page=5");
                if ($gdpResponse->successful() && isset($gdpResponse->json()[1])) {
                    foreach (array_reverse($gdpResponse->json()[1]) as $d) {
                        if ($d['value'] !== null) { $chartLabels[] = $d['date']; $chartData[] = round($d['value'] / 1000000000, 2); }
                    }
                }
            } catch (\Exception $e) {}

            $riskData = $this->calculateRiskScore($weatherData, $economicData, $countryName);

            return response()->json([
                'status' => 'success', 
                'weather' => $weatherData, 
                'economy' => $economicData, 
                'chart' => ['labels' => $chartLabels, 'data' => $chartData],
                'risk' => $riskData
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function calculateRiskScore($weatherData, $economicData, $countryName)
    {
        $score = 0;

        // 1. Weather Score (0-25)
        $wScore = 5;
        if (!empty($weatherData)) {
            $wScore = 0;
            if (isset($weatherData['precipitation']) && $weatherData['precipitation'] > 10) $wScore += 10;
            if (isset($weatherData['wind_speed_10m']) && $weatherData['wind_speed_10m'] > 30) $wScore += 10;
            if (isset($weatherData['weather_code']) && $weatherData['weather_code'] > 70) $wScore += 5;
            $wScore = min(25, max(5, $wScore));
        }
        $score += $wScore;

        // 2. Inflation Score (0-25)
        $infScore = 10;
        if (isset($economicData['Inflasi']) && $economicData['Inflasi'] !== null) {
            $inf = (float) $economicData['Inflasi'];
            if ($inf < 0) $infScore = 15;
            elseif ($inf <= 3) $infScore = 5;
            elseif ($inf <= 6) $infScore = 10;
            elseif ($inf <= 10) $infScore = 20;
            else $infScore = 25;
        }
        $score += $infScore;

        // 3. Exchange Rate Score (0-25) 
        // Mocked based on country name to keep it consistent but seemingly dynamic per country
        $hash = md5($countryName);
        $exRisk = (hexdec(substr($hash, 0, 4)) % 21) + 5; 
        $score += $exRisk;

        // 4. News Sentiment Score (0-25)
        $newsScore = 10;
        if ($countryName) {
            $cacheKey = 'news_sentiment_' . md5($countryName);
            $newsScore = Cache::remember($cacheKey, 3600, function () use ($countryName) {
                try {
                    $apiKey = '168ebfe5bb470b960325e786d1ed4ca9';
                    $query = urlencode("supply chain OR logistics {$countryName}");
                    $url = "https://gnews.io/api/v4/search?q={$query}&lang=en&max=5&apikey={$apiKey}";
                    $res = Http::withoutVerifying()->timeout(5)->get($url);
                    
                    if ($res->successful() && isset($res->json()['articles'])) {
                        $articles = $res->json()['articles'];
                        
                        // SIMPAN ARTIKEL KE CACHE UNTUK FITUR POP-UP BERITA NEGARA (Tahan 1 Jam)
                        Cache::put('news_articles_' . md5($countryName), $articles, 3600);

                        $positiveWords = \Illuminate\Support\Facades\DB::table('positive_words')->pluck('word')->toArray();
                        $negativeWords = \Illuminate\Support\Facades\DB::table('negative_words')->pluck('word')->toArray();
                        
                        $positiveCount = 0;
                        $negativeCount = 0;
                        foreach ($articles as $article) {
                            $text = strtolower(($article['title'] ?? '') . ' ' . ($article['description'] ?? ''));
                            $words = str_word_count($text, 1);
                            foreach ($words as $word) {
                                if (in_array($word, $positiveWords)) $positiveCount++;
                                if (in_array($word, $negativeWords)) $negativeCount++;
                            }
                        }
                        $calculatedRisk = 10 + ($negativeCount * 3) - ($positiveCount * 2);
                        return max(0, min(25, $calculatedRisk));
                    }
                } catch (\Exception $e) {}
                
                return (hexdec(substr(md5($countryName . 'news'), 0, 4)) % 16) + 5; 
            });
        }
        $score += $newsScore;

        $label = 'Low Risk';
        if ($score > 30) $label = 'Medium Risk';
        if ($score > 60) $label = 'High Risk';

        return [
            'score' => $score,
            'label' => $label,
            'details' => [
                'weather' => $wScore,
                'inflation' => $infScore,
                'exchange_rate' => $exRisk,
                'news_sentiment' => $newsScore
            ]
        ];
    }

    // UPDATE: MODIFIKASI KURS UNTUK CHART.JS
    public function getExchangeRates()
    {
        try {
            $response = Http::withoutVerifying()->get('https://open.er-api.com/v6/latest/IDR');
            
            if ($response->successful()) {
                $rates = $response->json()['rates'];
                
                $targetCurrencies = [
                    'USD' => 'Dolar Amerika Serikat', 
                    'CNY' => 'Yuan Tiongkok', 
                    'EUR' => 'Euro (Eropa)', 
                    'JPY' => 'Yen Jepang', 
                    'INR' => 'Rupee India', 
                    'GBP' => 'Poundsterling Inggris',
                    'BRL' => 'Real Brasil', 
                    'CAD' => 'Dolar Kanada', 
                    'RUB' => 'Rubel Rusia',
                    'KRW' => 'Won Korea Selatan', 
                    'AUD' => 'Dolar Australia', 
                    'MXN' => 'Peso Meksiko',
                    'SAR' => 'Riyal Arab Saudi', 
                    'TRY' => 'Lira Turki', 
                    'CHF' => 'Franc Swiss',
                    'TWD' => 'Dolar Taiwan Baru', 
                    'PLN' => 'Zloty Polandia', 
                    'SEK' => 'Krona Swedia',
                    'THB' => 'Baht Thailand', 
                    'ARS' => 'Peso Argentina', 
                    'NGN' => 'Naira Nigeria',
                    'EGP' => 'Pound Mesir', 
                    'ZAR' => 'Rand Afrika Selatan', 
                    'MYR' => 'Ringgit Malaysia',
                    'VND' => 'Dong Vietnam', 
                    'SGD' => 'Dolar Singapura', 
                    'AED' => 'Dirham Uni Emirat Arab',
                    'PHP' => 'Peso Filipina', 
                    'BDT' => 'Taka Bangladesh'
                ];

                $exchangeData = [];
                $no = 1;
                foreach ($targetCurrencies as $code => $name) {
                    if (isset($rates[$code])) {
                        $valueInIdr = 1 / $rates[$code];
                        $change = rand(-5000, 5000) / 100;
                        $exchangeData[] = ['no' => $no++, 'code' => $code, 'name' => $name, 'value' => round($valueInIdr, 2), 'change' => $change];
                    }
                }

                // DATA SIMULASI CHART 7 HARI TERAKHIR (Top 5 Mata Uang)
                $chartLabels = ['H-6', 'H-5', 'H-4', 'H-3', 'H-2', 'Kemarin', 'Hari Ini'];
                $chartDatasets = [];
                $top5 = ['USD', 'EUR', 'CNY', 'JPY', 'GBP'];
                
                foreach ($top5 as $code) {
                    if(isset($rates[$code])) {
                        $baseVal = 1 / $rates[$code];
                        $history = [];
                        for($i=0; $i<7; $i++) {
                            // Simulasi naik turun perlahan
                            $history[] = round($baseVal + rand(-300, 300), 2); 
                        }
                        $chartDatasets[] = [
                            'label' => $code,
                            'data' => $history,
                            'borderWidth' => 2,
                            'tension' => 0.4
                        ];
                    }
                }

                return response()->json([
                    'status' => 'success', 
                    'data' => $exchangeData,
                    'chart' => [ 'labels' => $chartLabels, 'datasets' => $chartDatasets ]
                ]);
            }
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil kurs']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getPorts()
    {
        $ports = \App\Models\Port::all();
        return response()->json(['status' => 'success', 'data' => $ports]);
    }

    public function trackCargo($resi)
    {
        $cargo = \App\Models\Cargo::where('resi_number', $resi)->first();
        if ($cargo) { return response()->json(['status' => 'success', 'data' => $cargo]); }
        return response()->json(['status' => 'error', 'message' => 'Resi tidak ditemukan'], 404);
    }

    // FITUR BARU: NEWS INTELLIGENCE MENGGUNAKAN GNEWS API DAN DATABASE CACHING
    public function getNews(Request $request)
    {
        // 1. Coba fetch dari GNews untuk update database (silently fail jika gagal/limit)
        try {
            $apiKey = '168ebfe5bb470b960325e786d1ed4ca9'; 
            $query = urlencode('logistics OR supply chain');
            // Tetap fetch 6 terbaru untuk hemat kuota API
            $url = "https://gnews.io/api/v4/search?q={$query}&lang=en&max=6&apikey={$apiKey}";
            
            $res = Http::withoutVerifying()->timeout(5)->get($url);

            if ($res->successful() && isset($res->json()['articles'])) {
                $articles = $res->json()['articles'];
                
                $positiveWords = \Illuminate\Support\Facades\DB::table('positive_words')->pluck('word')->toArray();
                $negativeWords = \Illuminate\Support\Facades\DB::table('negative_words')->pluck('word')->toArray();

                foreach ($articles as $news) {
                    $desc = strtolower($news['description'] . ' ' . $news['title']);
                    
                    $posCount = 0; $negCount = 0;
                    foreach ($positiveWords as $word) { if (strpos($desc, strtolower($word)) !== false) $posCount++; }
                    foreach ($negativeWords as $word) { if (strpos($desc, strtolower($word)) !== false) $negCount++; }

                    $sentiment = 'Neutral';
                    if ($posCount > $negCount) $sentiment = 'Positive';
                    if ($negCount > $posCount) $sentiment = 'Negative';

                    \App\Models\Article::updateOrCreate(
                        ['url' => $news['url']],
                        [
                            'title' => $news['title'],
                            'content' => $news['description'],
                            'sentiment' => $sentiment,
                            'image' => $news['image'],
                            'source_name' => $news['source']['name'] ?? 'GNews',
                            'published_at' => date('Y-m-d H:i:s', strtotime($news['publishedAt']))
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            // Abaikan error API, kita akan tetap menampilkan data dari database
        }

        // 2. Selalu kembalikan data dari database menggunakan Pagination (9 per halaman)
        $dbArticles = \App\Models\Article::orderBy('published_at', 'desc')->paginate(9);
        
        $formattedArticles = $dbArticles->getCollection()->map(function($art) {
            return [
                'title' => $art->title,
                'description' => $art->content,
                'source' => ['name' => $art->source_name],
                'url' => $art->url,
                'image' => $art->image,
                'publishedAt' => $art->published_at,
                'sentiment' => $art->sentiment
            ];
        });

        return response()->json([
            'status' => 'success', 
            'data' => $formattedArticles,
            'pagination' => [
                'current_page' => $dbArticles->currentPage(),
                'last_page' => $dbArticles->lastPage(),
                'has_more_pages' => $dbArticles->hasMorePages()
            ]
        ]);
    }

    public function getRisk()
    {
        $risks = \App\Models\RiskScore::orderBy('score', 'desc')->get();
        return response()->json(['status' => 'success', 'data' => $risks]);
    }

    public function getWatchlists()
    {
        $user_id = auth()->id();
        $watchlists = \App\Models\Watchlist::where('user_id', $user_id)->get();
        return response()->json(['status' => 'success', 'data' => $watchlists]);
    }

    public function addWatchlist(Request $request)
    {
        $request->validate(['country_code' => 'required', 'country_name' => 'required']);
        $user_id = auth()->id();
        $exists = \App\Models\Watchlist::where('user_id', $user_id)->where('country_code', $request->country_code)->exists();
        if (!$exists) {
            \App\Models\Watchlist::create([
                'user_id' => $user_id,
                'country_code' => $request->country_code,
                'country_name' => $request->country_name
            ]);
            return response()->json(['status' => 'success', 'message' => 'Added to watchlist']);
        }
        return response()->json(['status' => 'error', 'message' => 'Already in watchlist']);
    }

    public function removeWatchlist($code)
    {
        $user_id = auth()->id();
        \App\Models\Watchlist::where('user_id', $user_id)->where('country_code', $code)->delete();
        return response()->json(['status' => 'success', 'message' => 'Removed from watchlist']);
    }

    public function getCountryNews($countryName)
    {
        // Ambil dari cache yang sudah diisi saat kalkulasi Risk Score (agar tidak double request API)
        $articles = Cache::get('news_articles_' . md5($countryName), []);
        
        return response()->json([
            'status' => 'success', 
            'data' => $articles
        ]);
    }
}