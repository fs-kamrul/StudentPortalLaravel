<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentAuthController;

// Default route - redirect to login or dashboard based on authentication
Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
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
        
        // Result routes
        Route::get('/result', [\App\Http\Controllers\ResultController::class, 'index'])->name('result.index');
        Route::post('/result/show', [\App\Http\Controllers\ResultController::class, 'show'])->name('result.show');
    });
});

// Bkash Payment Routes (outside student prefix for callback)
Route::prefix('bkash')->name('bkash.')->middleware('student.auth')->group(function () {
    Route::get('/payment/{testimonial_id}', [\App\Http\Controllers\BkashPaymentController::class, 'createPayment'])->name('payment');
    Route::get('/callback/{testimonial_id}', [\App\Http\Controllers\BkashPaymentController::class, 'callback'])->name('callback');
});

// Admin Bkash Payment Routes
Route::prefix('admin/bkash')->name('admin.bkash.')->middleware('admin.auth')->group(function () {
    Route::get('/payment/{testimonial_id}', [\App\Http\Controllers\AdminBkashPaymentController::class, 'createPayment'])->name('payment');
    Route::get('/callback/{testimonial_id}', [\App\Http\Controllers\AdminBkashPaymentController::class, 'callback'])->name('callback');
});



// Admin Root Redirect
Route::get('/admin', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes (not authenticated)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [\App\Http\Controllers\AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [\App\Http\Controllers\AdminAuthController::class, 'login']);
    });

    // Authenticated routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/students', [\App\Http\Controllers\AdminStudentController::class, 'index'])->name('students.index');
        Route::get('/students/{id}', [\App\Http\Controllers\AdminStudentController::class, 'show'])->name('students.show');
        // Testimonial Routes
        Route::get('/testimonials', [\App\Http\Controllers\AdminTestimonialController::class, 'index'])->name('testimonials.index');
        Route::get('/testimonials/create', [\App\Http\Controllers\AdminTestimonialController::class, 'create'])->name('testimonials.create');
        Route::post('/testimonials', [\App\Http\Controllers\AdminTestimonialController::class, 'store'])->name('testimonials.store');
        Route::post('/testimonials/{id}/status/{status}', [\App\Http\Controllers\AdminTestimonialController::class, 'updateStatus'])->name('testimonials.updateStatus');
        Route::post('/testimonials/{id}/payment-status/{payment_status}', [\App\Http\Controllers\AdminTestimonialController::class, 'updatePaymentStatus'])->name('testimonials.updatePaymentStatus');
        
        Route::post('/students/{id}/reset-password', [\App\Http\Controllers\AdminStudentController::class, 'resetPassword'])->name('students.resetPassword');
        Route::post('/students/reset-all-passwords', [\App\Http\Controllers\AdminStudentController::class, 'resetAllPasswords'])->name('students.resetAllPasswords');
        
        // Change Password Routes
        Route::get('/change-password', [\App\Http\Controllers\AdminAuthController::class, 'showChangePasswordForm'])->name('password.change');
        Route::post('/change-password', [\App\Http\Controllers\AdminAuthController::class, 'changePassword'])->name('password.update');
        
        // Creative Questions (CQ) Routes
        // CQ Subject Routes
        Route::prefix('cq/subjects')->name('cq.subjects.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminCqSubjectController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\AdminCqSubjectController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\AdminCqSubjectController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\AdminCqSubjectController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\AdminCqSubjectController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\AdminCqSubjectController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [\App\Http\Controllers\AdminCqSubjectController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force', [\App\Http\Controllers\AdminCqSubjectController::class, 'forceDestroy'])->name('forceDestroy');
        });

        // CQ Chapter Routes
        Route::prefix('cq/chapters')->name('cq.chapters.')->group(function () {
            Route::get('/subject/{subjectId}', [\App\Http\Controllers\AdminCqChapterController::class, 'index'])->name('index');
            Route::get('/subject/{subjectId}/create', [\App\Http\Controllers\AdminCqChapterController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\AdminCqChapterController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\AdminCqChapterController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\AdminCqChapterController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\AdminCqChapterController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [\App\Http\Controllers\AdminCqChapterController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force', [\App\Http\Controllers\AdminCqChapterController::class, 'forceDestroy'])->name('forceDestroy');
        });

        // CQ Question Routes
        Route::prefix('cq/questions')->name('cq.questions.')->group(function () {
            Route::get('/chapter/{chapterId}', [\App\Http\Controllers\AdminCqQuestionController::class, 'index'])->name('index');
            Route::get('/chapter/{chapterId}/create', [\App\Http\Controllers\AdminCqQuestionController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\AdminCqQuestionController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\AdminCqQuestionController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\App\Http\Controllers\AdminCqQuestionController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\AdminCqQuestionController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\AdminCqQuestionController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [\App\Http\Controllers\AdminCqQuestionController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force', [\App\Http\Controllers\AdminCqQuestionController::class, 'forceDestroy'])->name('forceDestroy');
        });

        // CQ Set Routes
        Route::prefix('cq/sets')->name('cq.sets.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminCqSetController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\AdminCqSetController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\AdminCqSetController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\AdminCqSetController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\AdminCqSetController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\AdminCqSetController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/restore', [\App\Http\Controllers\AdminCqSetController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force', [\App\Http\Controllers\AdminCqSetController::class, 'forceDestroy'])->name('forceDestroy');
            Route::get('/{id}/add-questions', [\App\Http\Controllers\AdminCqSetController::class, 'addQuestions'])->name('addQuestions');
            Route::post('/{id}/questions', [\App\Http\Controllers\AdminCqSetController::class, 'storeQuestions'])->name('storeQuestions');
            Route::get('/{id}/preview', [\App\Http\Controllers\AdminCqSetController::class, 'preview'])->name('preview');
            Route::get('/{id}/pdf', [\App\Http\Controllers\AdminCqSetController::class, 'generatePdf'])->name('pdf');
        });

        // CQ Part Questions (Question Bank - 4 Types)
        Route::prefix('cq/qbank')->name('cq.part_questions.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminChapterQuestionController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\AdminChapterQuestionController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\AdminChapterQuestionController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\App\Http\Controllers\AdminChapterQuestionController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\AdminChapterQuestionController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\AdminChapterQuestionController::class, 'destroy'])->name('destroy');
        });
        
        Route::post('/logout', [\App\Http\Controllers\AdminAuthController::class, 'logout'])->name('logout');
    });
});
