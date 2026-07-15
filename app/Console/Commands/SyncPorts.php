<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Port;

class SyncPorts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:ports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync sea ports from GitHub API to local database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching ports data...');
        
        try {
            // Using HTTP client to fetch raw JSON of sea ports (World Port Index derived)
            $response = Http::withoutVerifying()->timeout(60)->get('https://raw.githubusercontent.com/marchah/sea-ports/master/lib/ports.json');
            
            if ($response->successful()) {
                $portsData = $response->json();
                $count = 0;
                
                $this->output->progressStart(count($portsData));

                foreach ($portsData as $unlocode => $p) {
                    $name = $p['name'] ?? null;
                    $country = $p['country'] ?? null;
                    
                    // Coordinates usually come as [lng, lat] in this dataset
                    $lng = null;
                    $lat = null;
                    if (isset($p['coordinates']) && is_array($p['coordinates']) && count($p['coordinates']) == 2) {
                        $lng = $p['coordinates'][0];
                        $lat = $p['coordinates'][1];
                    }
                    
                    if (!$name || !$lat || !$lng) {
                        $this->output->progressAdvance();
                        continue;
                    }

                    // Update or create the port
                    Port::updateOrCreate(
                        ['name' => $name], // Assuming name is unique enough for our simple DB, though UNLOCODE is better, the table only has name
                        [
                            'country' => $country,
                            'lat' => $lat,
                            'lng' => $lng,
                        ]
                    );
                    
                    $count++;
                    $this->output->progressAdvance();
                }
                
                $this->output->progressFinish();
                $this->info("Successfully synced {$count} ports to the database.");
            } else {
                $this->error('Failed to fetch from API. HTTP Status: ' . $response->status());
            }
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}
