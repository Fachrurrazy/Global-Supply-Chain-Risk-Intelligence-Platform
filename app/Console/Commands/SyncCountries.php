<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class SyncCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync countries from REST Countries API to local database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching countries from REST Countries API...');
        
        try {
            // Using HTTP client without verifying SSL in case of local cert issues
            $response = Http::withoutVerifying()->timeout(30)->get('https://raw.githubusercontent.com/mledoze/countries/master/countries.json');
            
            if ($response->successful()) {
                $countries = $response->json();
                $count = 0;
                
                $this->output->progressStart(count($countries));

                foreach ($countries as $c) {
                    $code = $c['cca2'] ?? null;
                    $name = $c['name']['common'] ?? null;
                    
                    if (!$code || !$name) {
                        $this->output->progressAdvance();
                        continue;
                    }

                    // Extract currency (take the first one)
                    $currencyCode = null;
                    if (isset($c['currencies']) && is_array($c['currencies'])) {
                        $currencyCode = array_key_first($c['currencies']);
                    }

                    // Extract language (take the first one)
                    $languageName = null;
                    if (isset($c['languages']) && is_array($c['languages'])) {
                        $languageName = reset($c['languages']);
                    }

                    // Extract Lat/Lng
                    $lat = null;
                    $lng = null;
                    if (isset($c['latlng']) && is_array($c['latlng']) && count($c['latlng']) == 2) {
                        $lat = $c['latlng'][0];
                        $lng = $c['latlng'][1];
                    }

                    Country::updateOrCreate(
                        ['code' => $code],
                        [
                            'name' => $name,
                            'currency' => $currencyCode,
                            'region' => $c['region'] ?? null,
                            'language' => $languageName,
                            'lat' => $lat,
                            'lng' => $lng,
                        ]
                    );
                    
                    $count++;
                    $this->output->progressAdvance();
                }
                
                $this->output->progressFinish();
                $this->info("Successfully synced {$count} countries to the database.");
            } else {
                $this->error('Failed to fetch from API. HTTP Status: ' . $response->status());
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
