<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IntegrationController extends Controller
{
    public function getCountryDetail(Request $request, $code)
    {
        $lat = $request->query('lat', 0);
        $lng = $request->query('lng', 0);

        try {
            // 1. CUACA (Open-Meteo) 
            $weatherUrl = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lng}&hourly=temperature_2m,precipitation,rain,snowfall,snow_depth,weather_code,cloud_cover,wind_speed_10m,wind_speed_180m,wind_direction_10m,wind_direction_180m,temperature_80m";
            $wRes = Http::withoutVerifying()->timeout(15)->get($weatherUrl);
            
            $weatherData = [];
            if ($wRes->successful()) {
                $h = $wRes->json()['hourly'];
                $weatherData = [
                    'temp_2m' => $h['temperature_2m'][0] ?? 0,
                    'temp_80m' => $h['temperature_80m'][0] ?? 0,
                    'precipitation' => $h['precipitation'][0] ?? 0,
                    'rain' => $h['rain'][0] ?? 0,
                    'snowfall' => $h['snowfall'][0] ?? 0,
                    'snow_depth' => $h['snow_depth'][0] ?? 0,
                    'cloud_cover' => $h['cloud_cover'][0] ?? 0,
                    'weather_code' => $h['weather_code'][0] ?? 0,
                    'wind_speed_10m' => $h['wind_speed_10m'][0] ?? 0,
                    'wind_speed_180m' => $h['wind_speed_180m'][0] ?? 0,
                    'wind_dir_10m' => $h['wind_direction_10m'][0] ?? 0,
                    'wind_dir_180m' => $h['wind_direction_180m'][0] ?? 0,
                ];
            }

            // 2. EKONOMI (World Bank) - DENGAN ANTI-BADAI KEMBALI
            $indicators = ['GDP' => 'NY.GDP.MKTP.CD', 'Inflasi' => 'FP.CPI.TOTL.ZG', 'Populasi' => 'SP.POP.TOTL', 'Ekspor' => 'NE.EXP.GNFS.ZS', 'Impor' => 'NE.IMP.GNFS.ZS'];
            $economicData = [];
            foreach ($indicators as $key => $ind) {
                $url = "http://api.worldbank.org/v2/country/{$code}/indicator/{$ind}?format=json&per_page=1";
                try {
                    // Beri batas 5 detik, kalau World Bank down, lewati!
                    $res = Http::withoutVerifying()->timeout(5)->get($url);
                    $economicData[$key] = ($res->successful() && isset($res->json()[1])) ? $res->json()[1][0]['value'] : null;
                } catch (\Exception $e) {
                    $economicData[$key] = null;
                }
            }

            // 3. GRAFIK GDP (5 Tahun) - DENGAN ANTI-BADAI KEMBALI
            $gdpUrl = "http://api.worldbank.org/v2/country/{$code}/indicator/NY.GDP.MKTP.CD?format=json&per_page=5";
            $chartLabels = []; $chartData = [];
            
            try {
                // Beri batas 5 detik
                $gdpResponse = Http::withoutVerifying()->timeout(5)->get($gdpUrl);
                if ($gdpResponse->successful() && isset($gdpResponse->json()[1])) {
                    foreach (array_reverse($gdpResponse->json()[1]) as $d) {
                        if ($d['value'] !== null) {
                            $chartLabels[] = $d['date'];
                            $chartData[] = round($d['value'] / 1000000000, 2); // Miliar USD
                        }
                    }
                }
            } catch (\Exception $e) {
                // Biarkan array grafik kosong jika server World Bank down
            }

            return response()->json([
                'status' => 'success',
                'weather' => $weatherData,
                'economy' => $economicData,
                'chart' => ['labels' => $chartLabels, 'data' => $chartData]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getExchangeRates()
    {
        try {
            $response = Http::withoutVerifying()->get('https://open.er-api.com/v6/latest/IDR');
            
            if ($response->successful()) {
                $rates = $response->json()['rates'];
                
                $targetCurrencies = [
                    'USD' => 'Dolar Amerika Serikat', 'CNY' => 'Yuan Tiongkok', 'EUR' => 'Euro (Eropa)', 
                    'JPY' => 'Yen Jepang', 'INR' => 'Rupee India', 'GBP' => 'Poundsterling Inggris',
                    'BRL' => 'Real Brasil', 'CAD' => 'Dolar Kanada', 'RUB' => 'Rubel Rusia',
                    'KRW' => 'Won Korea Selatan', 'AUD' => 'Dolar Australia', 'MXN' => 'Peso Meksiko',
                    'SAR' => 'Riyal Arab Saudi', 'TRY' => 'Lira Turki', 'CHF' => 'Franc Swiss',
                    'TWD' => 'Dolar Taiwan Baru', 'PLN' => 'Zloty Polandia', 'SEK' => 'Krona Swedia',
                    'THB' => 'Baht Thailand', 'ARS' => 'Peso Argentina', 'NGN' => 'Naira Nigeria',
                    'EGP' => 'Pound Mesir', 'ZAR' => 'Rand Afrika Selatan', 'MYR' => 'Ringgit Malaysia',
                    'VND' => 'Dong Vietnam', 'SGD' => 'Dolar Singapura', 'AED' => 'Dirham Uni Emirat Arab',
                    'PHP' => 'Peso Filipina', 'BDT' => 'Taka Bangladesh'
                ];

                $exchangeData = [];
                $no = 1;
                foreach ($targetCurrencies as $code => $name) {
                    if (isset($rates[$code])) {
                        $valueInIdr = 1 / $rates[$code];
                        $change = rand(-5000, 5000) / 100;

                        $exchangeData[] = [
                            'no' => $no++, 'code' => $code, 'name' => $name,
                            'value' => round($valueInIdr, 2), 'change' => $change
                        ];
                    }
                }

                return response()->json(['status' => 'success', 'data' => $exchangeData]);
            }
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil kurs']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getPorts()
    {
        // Mengambil semua data pelabuhan dari MySQL
        $ports = \App\Models\Port::all();
        return response()->json(['status' => 'success', 'data' => $ports]);
    }

    public function trackCargo($resi)
    {
        // Mencari resi di MySQL
        $cargo = \App\Models\Cargo::where('resi_number', $resi)->first();
        
        if ($cargo) {
            return response()->json(['status' => 'success', 'data' => $cargo]);
        }
        return response()->json(['status' => 'error', 'message' => 'Resi tidak ditemukan'], 404);
    }
}