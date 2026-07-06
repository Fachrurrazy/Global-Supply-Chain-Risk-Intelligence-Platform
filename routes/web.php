<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('');
});
Route::get('/', function () {
    return view('dashboard'); // Kita akan membuat file dashboard.blade.php
});
Route::get('/monitoring', function () {
    return view('monitoring');
});
Route::get('/news', function () {
    return view('news');
});