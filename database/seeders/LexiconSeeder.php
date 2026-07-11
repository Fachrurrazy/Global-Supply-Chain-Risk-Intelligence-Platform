<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LexiconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positive = [
            'growth', 'increase', 'profit', 'stable', 'improve', 'success', 'recovery',
            'boom', 'gain', 'surplus', 'boost', 'expand', 'efficient', 'safe', 'resolved'
        ];

        $negative = [
            'war', 'crisis', 'inflation', 'delay', 'disaster', 'shortage', 'disrupt',
            'conflict', 'strike', 'risk', 'problem', 'crash', 'fail', 'decrease', 'loss'
        ];

        foreach ($positive as $word) {
            \Illuminate\Support\Facades\DB::table('positive_words')->insertOrIgnore(['word' => $word, 'created_at' => now(), 'updated_at' => now()]);
        }

        foreach ($negative as $word) {
            \Illuminate\Support\Facades\DB::table('negative_words')->insertOrIgnore(['word' => $word, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
