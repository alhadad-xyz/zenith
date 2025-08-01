<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\TaskController;
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
    
    // Cover Letter Generation routes
    Route::get('applications/{application}/extract-resume-text', [JobApplicationController::class, 'extractResumeText'])->name('applications.extract-resume-text');
    Route::post('applications/{application}/generate-cover-letter', [JobApplicationController::class, 'generateCoverLetter'])->name('applications.generate-cover-letter');
    
    // Debug route for testing AI service
    Route::post('applications/{application}/test-ai', function(\App\Models\JobApplication $application) {
        try {
            $aiService = new \App\Services\CoverLetterAIService();
            return response()->json([
                'success' => true,
                'message' => 'AI service test successful',
                'provider' => $aiService->getProvider(),
                'ai_available' => $aiService->isAIAvailable(),
                'application' => [
                    'id' => $application->id,
                    'job_title' => $application->job_title,
                    'company_name' => $application->company_name
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    })->name('applications.test-ai');
    
    // Task routes
    Route::get('tasks/today', [TaskController::class, 'todayTasks'])->name('tasks.today');
    Route::resource('tasks', TaskController::class)->except(['create', 'edit']);
    Route::post('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
});
