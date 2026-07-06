<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogisticsSeeder extends Seeder
{
    public function run()
    {
        // 1. Masukkan Data Pelabuhan
        $ports = [
            ['name' => 'Tanjung Priok', 'country' => 'Indonesia (ID)', 'lat' => -6.10, 'lng' => 106.87],
            ['name' => 'Port of Shanghai', 'country' => 'China (CN)', 'lat' => 31.22, 'lng' => 121.48],
            ['name' => 'Port of Singapore', 'country' => 'Singapore (SG)', 'lat' => 1.26, 'lng' => 103.82],
            ['name' => 'Port of Rotterdam', 'country' => 'Netherlands (NL)', 'lat' => 51.94, 'lng' => 4.14],
            ['name' => 'Port of Los Angeles', 'country' => 'United States (US)', 'lat' => 33.72, 'lng' => -118.26],
            ['name' => 'Jebel Ali Port', 'country' => 'UAE (AE)', 'lat' => 25.01, 'lng' => 55.05],
            ['name' => 'Port of Hamburg', 'country' => 'Germany (DE)', 'lat' => 53.54, 'lng' => 9.99],
            ['name' => 'Port of Santos', 'country' => 'Brazil (BR)', 'lat' => -23.97, 'lng' => -46.29],
            ['name' => 'Port of Durban', 'country' => 'South Africa (ZA)', 'lat' => -29.87, 'lng' => 31.02],
            ['name' => 'Port of Yokohama', 'country' => 'Japan (JP)', 'lat' => 35.45, 'lng' => 139.65],
            ['name' => 'Port of Sydney', 'country' => 'Australia (AU)', 'lat' => -33.85, 'lng' => 151.21],
            ['name' => 'Nhava Sheva Port', 'country' => 'India (IN)', 'lat' => 18.94, 'lng' => 72.94],
            ['name' => 'Port of Felixstowe', 'country' => 'United Kingdom (GB)', 'lat' => 51.95, 'lng' => 1.31],
            ['name' => 'Port of Le Havre', 'country' => 'France (FR)', 'lat' => 49.48, 'lng' => 0.10],
            ['name' => 'Port of Genoa', 'country' => 'Italy (IT)', 'lat' => 44.40, 'lng' => 8.91],
            ['name' => 'Port of Novorossiysk', 'country' => 'Russia (RU)', 'lat' => 44.73, 'lng' => 37.78],
            ['name' => 'Port of Busan', 'country' => 'South Korea (KR)', 'lat' => 35.10, 'lng' => 129.04],
            ['name' => 'Port of Valencia', 'country' => 'Spain (ES)', 'lat' => 39.44, 'lng' => -0.31],
            ['name' => 'Port of Manzanillo', 'country' => 'Mexico (MX)', 'lat' => 19.06, 'lng' => -104.29],
            ['name' => 'Jeddah Islamic Port', 'country' => 'Saudi Arabia (SA)', 'lat' => 21.48, 'lng' => 39.16],
            ['name' => 'Port of Ambarli', 'country' => 'Turkey (TR)', 'lat' => 40.97, 'lng' => 28.68],
            ['name' => 'Port of Kaohsiung', 'country' => 'Taiwan (TW)', 'lat' => 22.56, 'lng' => 120.31],
            ['name' => 'Port of Gdansk', 'country' => 'Poland (PL)', 'lat' => 54.40, 'lng' => 18.66],
            ['name' => 'Port of Gothenburg', 'country' => 'Sweden (SE)', 'lat' => 57.69, 'lng' => 11.88],
            ['name' => 'Port of Antwerp', 'country' => 'Belgium (BE)', 'lat' => 51.26, 'lng' => 4.34],
            ['name' => 'Port of Laem Chabang', 'country' => 'Thailand (TH)', 'lat' => 13.08, 'lng' => 100.88],
            ['name' => 'Port of Buenos Aires', 'country' => 'Argentina (AR)', 'lat' => -34.58, 'lng' => -58.37],
            ['name' => 'Port of Lagos (Apapa)', 'country' => 'Nigeria (NG)', 'lat' => 6.44, 'lng' => 3.36],
            ['name' => 'Port of Alexandria', 'country' => 'Egypt (EG)', 'lat' => 31.18, 'lng' => 29.87],
            ['name' => 'Port Klang', 'country' => 'Malaysia (MY)', 'lat' => 3.00, 'lng' => 101.39],
            ['name' => 'Port of Ho Chi Minh', 'country' => 'Vietnam (VN)', 'lat' => 10.76, 'lng' => 106.74],
            ['name' => 'Port of Manila', 'country' => 'Philippines (PH)', 'lat' => 14.59, 'lng' => 120.96],
            ['name' => 'Port of Chittagong', 'country' => 'Bangladesh (BD)', 'lat' => 22.31, 'lng' => 91.80]
        ];
        DB::table('ports')->insert($ports);

        // 2. Masukkan Data Kargo (Simulasi Database)
       $cargos = [
            // --- Asia & Oceania ---
            [
                'resi_number' => 'INV-2026-JKT',
                'item' => 'Komponen Elektronik & Semikonduktor',
                'vessel' => 'Ever Given (IMO: 9811000)',
                'route' => 'Shanghai (CN) ➔ Tanjung Priok (ID)',
                'current_lat' => 5.5, 'current_lng' => 110.0, // Laut Cina Selatan
                'standard_eta' => '10 Juli 2026'
            ],
            [
                'resi_number' => 'INV-2026-SYD',
                'item' => 'Pakaian & Tekstil Premium',
                'vessel' => 'COSCO Shipping Universe',
                'route' => 'Ho Chi Minh (VN) ➔ Sydney (AU)',
                'current_lat' => -2.0, 'current_lng' => 130.0, // Laut Banda
                'standard_eta' => '12 Juli 2026'
            ],
            [
                'resi_number' => 'INV-2026-SGP',
                'item' => 'Gandum & Sereal',
                'vessel' => 'MSC Oscar',
                'route' => 'Sydney (AU) ➔ Singapore (SG)',
                'current_lat' => -15.5, 'current_lng' => 115.0, // Samudra Hindia (Timur)
                'standard_eta' => '14 Juli 2026'
            ],
            [
                'resi_number' => 'INV-2026-TOK',
                'item' => 'Gas Alam Cair (LNG)',
                'vessel' => 'Celsius Copenhagen (Tanker)',
                'route' => 'Jebel Ali (AE) ➔ Yokohama (JP)',
                'current_lat' => 22.0, 'current_lng' => 125.0, // Laut Filipina (Rawan Topan)
                'standard_eta' => '16 Juli 2026'
            ],
            [
                'resi_number' => 'INV-2026-MUM',
                'item' => 'Baterai Kendaraan Listrik (EV)',
                'vessel' => 'Ever Golden',
                'route' => 'Busan (KR) ➔ Nhava Sheva (IN)',
                'current_lat' => 5.0, 'current_lng' => 95.0, // Ujung utara Selat Malaka
                'standard_eta' => '18 Juli 2026'
            ],
            [
                'resi_number' => 'INV-2026-MAN',
                'item' => 'Beras & Gula Pasir',
                'vessel' => 'Wan Hai 805',
                'route' => 'Laem Chabang (TH) ➔ Manila (PH)',
                'current_lat' => 14.0, 'current_lng' => 115.0, // Tengah Laut Cina Selatan
                'standard_eta' => '20 Juli 2026'
            ],

            // --- Eropa & Timur Tengah ---
            [
                'resi_number' => 'INV-2026-RTM',
                'item' => 'Suku Cadang Otomotif',
                'vessel' => 'Maersk Mc-Kinney Moller',
                'route' => 'Los Angeles (US) ➔ Rotterdam (NL)',
                'current_lat' => 45.0, 'current_lng' => -30.0, // Samudra Atlantik Utara (Sering Badai)
                'standard_eta' => '22 Juli 2026'
            ],
            [
                'resi_number' => 'INV-2026-DXB',
                'item' => 'Mobil Mewah (Supercars)',
                'vessel' => 'CMA CGM Antoine de Saint Exupery',
                'route' => 'Hamburg (DE) ➔ Jebel Ali (AE)',
                'current_lat' => 35.0, 'current_lng' => 18.0, // Laut Mediterania
                'standard_eta' => '24 Juli 2026'
            ],
            [
                'resi_number' => 'INV-2026-LON',
                'item' => 'Mesin Industri Berat',
                'vessel' => 'OOCL Hong Kong',
                'route' => 'Shanghai (CN) ➔ Felixstowe (GB)',
                'current_lat' => 10.0, 'current_lng' => 65.0, // Laut Arab
                'standard_eta' => '25 Juli 2026'
            ],
            [
                'resi_number' => 'INV-2026-IST',
                'item' => 'Baja Konstruksi',
                'vessel' => 'ZIM Antwerp',
                'route' => 'Novorossiysk (RU) ➔ Ambarli (TR)',
                'current_lat' => 43.0, 'current_lng' => 34.0, // Laut Hitam
                'standard_eta' => '27 Juli 2026'
            ],
            [
                'resi_number' => 'INV-2026-MAD',
                'item' => 'Panel Surya',
                'vessel' => 'CMA CGM Jacques Saade',
                'route' => 'Ningbo (CN) ➔ Valencia (ES)',
                'current_lat' => 12.0, 'current_lng' => 45.0, // Teluk Aden / Laut Merah
                'standard_eta' => '29 Juli 2026'
            ],
            [
                'resi_number' => 'INV-2026-STO',
                'item' => 'Kertas & Kayu Pulp',
                'vessel' => 'Maersk Eindhoven',
                'route' => 'Gothenburg (SE) ➔ Rotterdam (NL)',
                'current_lat' => 55.0, 'current_lng' => 5.0, // Laut Utara Eropa
                'standard_eta' => '02 Agustus 2026'
            ],

            // --- Amerika (Utara & Selatan) ---
            [
                'resi_number' => 'INV-2026-NYC',
                'item' => 'Alat Kesehatan & Farmasi',
                'vessel' => 'Hapag-Lloyd Colombo Express',
                'route' => 'Rotterdam (NL) ➔ Los Angeles (US)',
                'current_lat' => 40.0, 'current_lng' => -50.0, // Samudra Atlantik Tengah
                'standard_eta' => '04 Agustus 2026'
            ],
            [
                'resi_number' => 'INV-2026-BUE',
                'item' => 'Bahan Kimia Industri',
                'vessel' => 'ONE Trust',
                'route' => 'Antwerp (BE) ➔ Buenos Aires (AR)',
                'current_lat' => -10.0, 'current_lng' => -30.0, // Samudra Atlantik Selatan
                'standard_eta' => '06 Agustus 2026'
            ],
            [
                'resi_number' => 'INV-2026-MEX',
                'item' => 'Kopi Mentah & Kakao',
                'vessel' => 'Yang Ming Well',
                'route' => 'Kaohsiung (TW) ➔ Manzanillo (MX)',
                'current_lat' => 20.0, 'current_lng' => -150.0, // Samudra Pasifik
                'standard_eta' => '08 Agustus 2026'
            ],
            [
                'resi_number' => 'INV-2026-RIO',
                'item' => 'Perlengkapan Tambang',
                'vessel' => 'CMA CGM Palais Royal',
                'route' => 'Le Havre (FR) ➔ Santos (BR)',
                'current_lat' => 10.0, 'current_lng' => -35.0, // Atlantik Tropis
                'standard_eta' => '10 Agustus 2026'
            ],
            [
                'resi_number' => 'INV-2026-VAN',
                'item' => 'Gawai & Smartphone',
                'vessel' => 'MSC Gulsun',
                'route' => 'Shenzhen (CN) ➔ Vancouver (CA)',
                'current_lat' => 45.0, 'current_lng' => 170.0, // Samudra Pasifik Utara (Rawan Ombak)
                'standard_eta' => '12 Agustus 2026'
            ],

            // --- Afrika & Rute Ekstrem Ekstra ---
            [
                'resi_number' => 'INV-2026-CPT',
                'item' => 'Biji Kopi Premium',
                'vessel' => 'MSC Amelia',
                'route' => 'Santos (BR) ➔ Durban (ZA)',
                'current_lat' => -35.0, 'current_lng' => 15.0, // Tanjung Harapan (Sangat Berangin)
                'standard_eta' => '14 Agustus 2026'
            ],
            [
                'resi_number' => 'INV-2026-LAG',
                'item' => 'Perangkat Telekomunikasi (BTS)',
                'vessel' => 'MSC Mina',
                'route' => 'Singapore (SG) ➔ Lagos (NG)',
                'current_lat' => -25.0, 'current_lng' => 55.0, // Samudra Hindia Barat
                'standard_eta' => '16 Agustus 2026'
            ],
            [
                'resi_number' => 'INV-2026-CAI',
                'item' => 'Daging Sapi Beku',
                'vessel' => 'HMM Algeciras',
                'route' => 'Buenos Aires (AR) ➔ Alexandria (EG)',
                'current_lat' => 30.0, 'current_lng' => -15.0, // Lepas Pantai Maroko
                'standard_eta' => '18 Agustus 2026'
            ],
            
            // --- Tambahan Rute Acak ---
            [
                'resi_number' => 'INV-2026-WAW',
                'item' => 'Suku Cadang Pesawat Komersial',
                'vessel' => 'Hapag-Lloyd Al Zubara',
                'route' => 'Los Angeles (US) ➔ Gdansk (PL)',
                'current_lat' => 58.0, 'current_lng' => -20.0, // Dekat Islandia (Rawan Cuaca Ekstrem)
                'standard_eta' => '20 Agustus 2026'
            ],
            [
                'resi_number' => 'INV-2026-KUL',
                'item' => 'Minyak Kelapa Sawit (CPO)',
                'vessel' => 'OOCL Germany',
                'route' => 'Port Klang (MY) ➔ Genoa (IT)',
                'current_lat' => 12.0, 'current_lng' => 55.0, // Laut Arab
                'standard_eta' => '22 Agustus 2026'
            ],
            [
                'resi_number' => 'INV-2026-HCM',
                'item' => 'Plastik & Polimer',
                'vessel' => 'ONE Blue',
                'route' => 'Yokohama (JP) ➔ Ho Chi Minh (VN)',
                'current_lat' => 20.0, 'current_lng' => 118.0, // Laut Cina Selatan
                'standard_eta' => '24 Agustus 2026'
            ],
            [
                'resi_number' => 'INV-2026-DAC',
                'item' => 'Pipa Besi Infrastruktur',
                'vessel' => 'COSCO Glory',
                'route' => 'Shanghai (CN) ➔ Chittagong (BD)',
                'current_lat' => 15.0, 'current_lng' => 88.0, // Teluk Benggala
                'standard_eta' => '26 Agustus 2026'
            ],
            [
                'resi_number' => 'INV-2026-BRU',
                'item' => 'Biji Kakao Mentah',
                'vessel' => 'MSC Isabella',
                'route' => 'Lagos (NG) ➔ Antwerp (BE)',
                'current_lat' => 20.0, 'current_lng' => -20.0, // Samudra Atlantik Tropis
                'standard_eta' => '28 Agustus 2026'
            ]
        ];
        DB::table('cargos')->insert($cargos);
    }
}