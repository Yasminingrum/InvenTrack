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

Route::post('/auth/session', [AuthController::class, 'storeSession'])->name('auth.session');
Route::post('/logout',       [AuthController::class, 'logout'])->name('logout');

// ── Firebase Email Action Handler (tanpa middleware, bisa diakses siapapun) ──
Route::get('/verify-email', fn() => view('auth.action'))->name('auth.action');

// ══════════════════════════════════════════════
// PROTECTED ROUTES
// ══════════════════════════════════════════════
Route::middleware('auth.firebase')->group(function () {

    // ── Semua role: Dashboard & Laporan ──
    Route::get('/products',        [ProductController::class, 'index'])->name('products.index');
    Route::get('/reports',         [ReportController::class,  'index'])->name('reports.index');

    // ── Admin & Superadmin: CRUD ──
    // ⚠️ PENTING: /products/create HARUS sebelum /products/{id}
    //    agar Laravel tidak salah tangkap "create" sebagai {id}
    Route::middleware('role:admin,superadmin')->group(function () {
        Route::get('/products/create',    [ProductController::class, 'create'])->name('products.create');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    });

    // ── Semua role: detail produk (setelah create agar tidak bentrok) ──
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    // ── Superadmin: Pengaturan ──
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/settings',       [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/settings/users', [SettingsController::class, 'users'])->name('settings.users');
        Route::post('/settings/users/{uid}/role', [SettingsController::class, 'updateRole'])->name('settings.users.role');
    });

});
