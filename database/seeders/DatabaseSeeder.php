<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Beritahu Laravel untuk menjalankan LogisticsSeeder juga!
        $this->call([
            LogisticsSeeder::class,
        ]);
    }
}