<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index()
    {
        // Data 35 Negara secara statis (Cepat, Aman dari Limit API, dan Anti-Error)
        $countries = [
            ['name' => 'United States', 'code' => 'US', 'region' => 'Americas', 'currency' => 'USD', 'lat' => 38.0, 'lng' => -97.0],
            ['name' => 'China', 'code' => 'CN', 'region' => 'Asia', 'currency' => 'CNY', 'lat' => 35.0, 'lng' => 105.0],
            ['name' => 'Germany', 'code' => 'DE', 'region' => 'Europe', 'currency' => 'EUR', 'lat' => 51.0, 'lng' => 9.0],
            ['name' => 'Japan', 'code' => 'JP', 'region' => 'Asia', 'currency' => 'JPY', 'lat' => 36.0, 'lng' => 138.0],
            ['name' => 'India', 'code' => 'IN', 'region' => 'Asia', 'currency' => 'INR', 'lat' => 20.0, 'lng' => 77.0],
            ['name' => 'United Kingdom', 'code' => 'GB', 'region' => 'Europe', 'currency' => 'GBP', 'lat' => 54.0, 'lng' => -2.0],
            ['name' => 'France', 'code' => 'FR', 'region' => 'Europe', 'currency' => 'EUR', 'lat' => 46.0, 'lng' => 2.0],
            ['name' => 'Italy', 'code' => 'IT', 'region' => 'Europe', 'currency' => 'EUR', 'lat' => 42.8, 'lng' => 12.8],
            ['name' => 'Brazil', 'code' => 'BR', 'region' => 'Americas', 'currency' => 'BRL', 'lat' => -10.0, 'lng' => -55.0],
            ['name' => 'Canada', 'code' => 'CA', 'region' => 'Americas', 'currency' => 'CAD', 'lat' => 60.0, 'lng' => -95.0],
            ['name' => 'Russia', 'code' => 'RU', 'region' => 'Europe', 'currency' => 'RUB', 'lat' => 60.0, 'lng' => 100.0],
            ['name' => 'South Korea', 'code' => 'KR', 'region' => 'Asia', 'currency' => 'KRW', 'lat' => 36.0, 'lng' => 128.0],
            ['name' => 'Australia', 'code' => 'AU', 'region' => 'Oceania', 'currency' => 'AUD', 'lat' => -27.0, 'lng' => 133.0],
            ['name' => 'Spain', 'code' => 'ES', 'region' => 'Europe', 'currency' => 'EUR', 'lat' => 40.0, 'lng' => -4.0],
            ['name' => 'Mexico', 'code' => 'MX', 'region' => 'Americas', 'currency' => 'MXN', 'lat' => 23.0, 'lng' => -102.0],
            ['name' => 'Indonesia', 'code' => 'ID', 'region' => 'Asia', 'currency' => 'IDR', 'lat' => -5.0, 'lng' => 120.0],
            ['name' => 'Netherlands', 'code' => 'NL', 'region' => 'Europe', 'currency' => 'EUR', 'lat' => 52.5, 'lng' => 5.75],
            ['name' => 'Saudi Arabia', 'code' => 'SA', 'region' => 'Asia', 'currency' => 'SAR', 'lat' => 25.0, 'lng' => 45.0],
            ['name' => 'Turkey', 'code' => 'TR', 'region' => 'Asia', 'currency' => 'TRY', 'lat' => 39.0, 'lng' => 35.0],
            ['name' => 'Switzerland', 'code' => 'CH', 'region' => 'Europe', 'currency' => 'CHF', 'lat' => 47.0, 'lng' => 8.0],
            ['name' => 'Taiwan', 'code' => 'TW', 'region' => 'Asia', 'currency' => 'TWD', 'lat' => 23.5, 'lng' => 121.0],
            ['name' => 'Poland', 'code' => 'PL', 'region' => 'Europe', 'currency' => 'PLN', 'lat' => 52.0, 'lng' => 20.0],
            ['name' => 'Sweden', 'code' => 'SE', 'region' => 'Europe', 'currency' => 'SEK', 'lat' => 62.0, 'lng' => 15.0],
            ['name' => 'Belgium', 'code' => 'BE', 'region' => 'Europe', 'currency' => 'EUR', 'lat' => 50.8, 'lng' => 4.0],
            ['name' => 'Thailand', 'code' => 'TH', 'region' => 'Asia', 'currency' => 'THB', 'lat' => 15.0, 'lng' => 100.0],
            ['name' => 'Argentina', 'code' => 'AR', 'region' => 'Americas', 'currency' => 'ARS', 'lat' => -34.0, 'lng' => -64.0],
            ['name' => 'Nigeria', 'code' => 'NG', 'region' => 'Africa', 'currency' => 'NGN', 'lat' => 10.0, 'lng' => 8.0],
            ['name' => 'Egypt', 'code' => 'EG', 'region' => 'Africa', 'currency' => 'EGP', 'lat' => 27.0, 'lng' => 30.0],
            ['name' => 'South Africa', 'code' => 'ZA', 'region' => 'Africa', 'currency' => 'ZAR', 'lat' => -29.0, 'lng' => 24.0],
            ['name' => 'Malaysia', 'code' => 'MY', 'region' => 'Asia', 'currency' => 'MYR', 'lat' => 2.5, 'lng' => 112.5],
            ['name' => 'Vietnam', 'code' => 'VN', 'region' => 'Asia', 'currency' => 'VND', 'lat' => 16.16, 'lng' => 107.83],
            ['name' => 'Singapore', 'code' => 'SG', 'region' => 'Asia', 'currency' => 'SGD', 'lat' => 1.36, 'lng' => 103.8],
            ['name' => 'United Arab Emirates', 'code' => 'AE', 'region' => 'Asia', 'currency' => 'AED', 'lat' => 24.0, 'lng' => 54.0],
            ['name' => 'Philippines', 'code' => 'PH', 'region' => 'Asia', 'currency' => 'PHP', 'lat' => 13.0, 'lng' => 122.0],
            ['name' => 'Bangladesh', 'code' => 'BD', 'region' => 'Asia', 'currency' => 'BDT', 'lat' => 24.0, 'lng' => 90.0]
        ];

        return response()->json([
            'status' => 'success',
            'count' => count($countries),
            'data' => $countries
        ]);
    }
}