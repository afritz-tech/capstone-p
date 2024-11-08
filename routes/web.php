<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    LandingController,
    HomeController,
    DashboardController,
    ProfileController,
    Auth\LoginController,
    Auth\RegisterController,
    Auth\ForgotPasswordController
};

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication Routes
Auth::routes();

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::post('/update', [ProfileController::class, 'updateProfile']);
        Route::get('/addresses', [ProfileController::class, 'getAddresses']);
        Route::post('/address', [ProfileController::class, 'addAddress']);
        Route::delete('/address/{id}', [ProfileController::class, 'deleteAddress']);
        Route::post('/phone', [ProfileController::class, 'addPhone']);
        Route::delete('/phone/{id}', [ProfileController::class, 'deletePhone']);
        Route::post('/upload', [ProfileController::class, 'uploadProfilePicture'])->name('profile.upload');
    });
});

// Static pages
Route::view('/privacy-policy', 'privacy_policy');

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');