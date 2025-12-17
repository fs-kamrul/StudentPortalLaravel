<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentAuthController;

// Default route - redirect to login or dashboard based on authentication
Route::get('/', function () {
    if (Auth::guard('student')->check()) {
        return redirect()->route('student.dashboard');
    }
    return redirect()->route('student.login');
});

// Student Authentication Routes
Route::prefix('student')->name('student.')->group(function () {
    // Guest routes (not authenticated)
    Route::middleware('guest:student')->group(function () {
        Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [StudentAuthController::class, 'login']);
    });

    // Authenticated routes
    Route::middleware('student.auth')->group(function () {
        // Password change routes (must be accessible even if password change is required)
        Route::get('/password/change', [\App\Http\Controllers\PasswordChangeController::class, 'showChangeForm'])->name('password.change');
        Route::post('/password/change', [\App\Http\Controllers\PasswordChangeController::class, 'changePassword'])->name('password.update');
        
        Route::get('/dashboard', [StudentAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout');
        
        // Testimonial routes
        Route::get('/testimonials', [\App\Http\Controllers\TestimonialController::class, 'index'])->name('testimonials.index');
        Route::get('/testimonials/create', [\App\Http\Controllers\TestimonialController::class, 'create'])->name('testimonials.create');
        Route::post('/testimonials', [\App\Http\Controllers\TestimonialController::class, 'store'])->name('testimonials.store');
    });
});

// Bkash Payment Routes (outside student prefix for callback)
Route::prefix('bkash')->name('bkash.')->middleware('student.auth')->group(function () {
    Route::get('/payment/{testimonial_id}', [\App\Http\Controllers\BkashPaymentController::class, 'createPayment'])->name('payment');
    Route::get('/callback/{testimonial_id}', [\App\Http\Controllers\BkashPaymentController::class, 'callback'])->name('callback');
});
