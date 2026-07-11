<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');
    
    Route::get('/monitoring', function () {
        return view('monitoring');
    })->name('monitoring');
    
    Route::get('/news', function () {
        return view('news');
    })->name('news');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Cargo Management
    Route::get('/cargo', [\App\Http\Controllers\Admin\CargoController::class, 'index'])->name('cargo.index');
    Route::post('/cargo', [\App\Http\Controllers\Admin\CargoController::class, 'store'])->name('cargo.store');
    
    // Port Management
    Route::get('/ports', [\App\Http\Controllers\Admin\PortController::class, 'index'])->name('ports.index');
    Route::post('/ports', [\App\Http\Controllers\Admin\PortController::class, 'store'])->name('ports.store');

    // Article / News Management
    Route::get('/articles', [\App\Http\Controllers\Admin\ArticleController::class, 'index'])->name('articles.index');
    Route::delete('/articles/{id}', [\App\Http\Controllers\Admin\ArticleController::class, 'destroy'])->name('articles.destroy');
});