<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('onboarding');
})->name('onboarding');

// Authentication routes
Route::get('/auth', [AuthController::class, 'showAuthPage'])->name('auth.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// API routes for authentication check
Route::get('/api/auth/check', [AuthController::class, 'checkAuth'])->name('auth.check');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/calendar', [AuthController::class, 'calendar'])->name('calendar');
    Route::get('/analytics', [AuthController::class, 'analytics'])->name('analytics');
    
    // Job Application routes
    Route::resource('applications', JobApplicationController::class)->except(['create']);
    
    // Application Events routes
    Route::post('applications/{application}/events', [JobApplicationController::class, 'storeEvent'])->name('applications.events.store');
});
