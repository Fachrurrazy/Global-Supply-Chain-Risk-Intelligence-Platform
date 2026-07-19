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
    }
}