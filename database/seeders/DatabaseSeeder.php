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
        // Buat akun default permanen agar tidak hilang saat Render restart
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Dosen',
                'password' => bcrypt('password123'),
                'role' => 'admin' // Sesuaikan jika ada kolom role
            ]
        );

        // Beritahu Laravel untuk menjalankan LogisticsSeeder dan LexiconSeeder juga!
        $this->call([
            LogisticsSeeder::class,
            LexiconSeeder::class,
        ]);

        // Sinkronisasi data negara secara otomatis (penting untuk server Production seperti Railway)
        $this->command->info('Menjalankan sinkronisasi data negara...');
        \Illuminate\Support\Facades\Artisan::call('sync:countries');
        $this->command->info('Sinkronisasi negara selesai.');
    }
}