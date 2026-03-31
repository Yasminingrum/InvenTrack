<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReportController;

// ── Root redirect ──
Route::get('/', function () {
    return redirect()->route('products.index');
});

// ══════════════════════════════════════════════
// AUTH ROUTES (Guest only)
// ══════════════════════════════════════════════
Route::middleware('guest.firebase')->group(function () {
    Route::get('/login',    [AuthController::class, 'loginPage'])->name('login');
    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
});

Route::post('/auth/session',           [AuthController::class, 'storeSession'])->name('auth.session');
Route::post('/logout',                 [AuthController::class, 'logout'])->name('logout');

// Kirim email verifikasi custom (dipanggil JS setelah Google register)
Route::post('/auth/send-verification', [AuthController::class, 'sendVerification'])->name('auth.send-verification');

// User klik link dari email (Google user) → verifikasi token → redirect ke login
Route::get('/auth/verify-email',       [AuthController::class, 'verifyEmail'])->name('auth.verify-email');

// User klik link Firebase (email/password user) → sync email_verified ke DB → redirect ke login
Route::get('/auth/verify-email-sync',  [AuthController::class, 'verifyEmailSync'])->name('auth.verify-email-sync');

// ══════════════════════════════════════════════
// PROTECTED ROUTES
// ══════════════════════════════════════════════
Route::middleware('auth.firebase')->group(function () {

    Route::get('/products',        [ProductController::class, 'index'])->name('products.index');
    Route::get('/reports',         [ReportController::class,  'index'])->name('reports.index');

    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/products/create',    [ProductController::class, 'create'])->name('products.create');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    });

    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    Route::middleware('role:superadmin')->group(function () {
        Route::get('/settings',       [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/settings/users', [SettingsController::class, 'users'])->name('settings.users');
        Route::post('/settings/users/{uid}/role', [SettingsController::class, 'updateRole'])->name('settings.users.role');
    });

});
