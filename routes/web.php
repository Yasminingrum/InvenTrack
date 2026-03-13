<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes — InvenTrack (Firebase BaaS + Firebase Auth)
|--------------------------------------------------------------------------
*/

// ── Root redirect ──
Route::get('/', function () {
    return redirect()->route('products.index');
});

// ══════════════════════════════════════════════
// AUTH ROUTES (Guest only — sudah login redirect)
// ══════════════════════════════════════════════
Route::middleware('guest.firebase')->group(function () {
    Route::get('/login',    [AuthController::class, 'loginPage'])->name('login');
    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
});

// Endpoint AJAX untuk menyimpan session setelah Firebase Auth
Route::post('/auth/session', [AuthController::class, 'storeSession'])->name('auth.session');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ══════════════════════════════════════════════
// PROTECTED ROUTES (Wajib login)
// ══════════════════════════════════════════════
Route::middleware('auth.firebase')->group(function () {
    // READ   — Daftar semua produk
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // CREATE — Form tambah produk baru
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    // VIEW   — Detail satu produk
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    // UPDATE — Form edit produk
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
});
