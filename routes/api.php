<?php
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\IntegrationController;
use Illuminate\Support\Facades\Route;

// 1. Master Data: Mengambil daftar 35 negara
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{code}', [CountryController::class, 'show']);

// 2. Data Detail: Mengambil data eksternal (Cuaca, GDP, Berita) saat negara diklik
Route::get('/country-data/{code}', [IntegrationController::class, 'getCountryDetail']);
Route::get('/exchange-rates', [IntegrationController::class, 'getExchangeRates']);
Route::get('/currency', [IntegrationController::class, 'getExchangeRates']); // Added for spec compliance
// Route untuk Halaman Monitoring
Route::get('/ports', [\App\Http\Controllers\Api\IntegrationController::class, 'getPorts']);
Route::get('/track-cargo/{resi}', [\App\Http\Controllers\Api\IntegrationController::class, 'trackCargo']);
// news
Route::get('/news', [\App\Http\Controllers\Api\IntegrationController::class, 'getNews']);
Route::get('/country-news/{countryName}', [\App\Http\Controllers\Api\IntegrationController::class, 'getCountryNews']);

// risk
Route::get('/risk', [\App\Http\Controllers\Api\IntegrationController::class, 'getRisk']);

// watchlist
Route::get('/watchlist', [\App\Http\Controllers\Api\IntegrationController::class, 'getWatchlists']);
Route::post('/watchlist', [\App\Http\Controllers\Api\IntegrationController::class, 'addWatchlist']);
Route::delete('/watchlist/{code}', [\App\Http\Controllers\Api\IntegrationController::class, 'removeWatchlist']);