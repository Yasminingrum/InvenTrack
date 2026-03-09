<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes — InvenTrack (Firebase BaaS Demo)
|--------------------------------------------------------------------------
|
| Rute ini menangani tampilan halaman. Operasi CRUD (Create, Read,
| Update, Delete) dilakukan langsung dari browser ke Firebase
| Realtime Database REST API menggunakan JavaScript (fetch API).
|
*/

// Dashboard / Daftar Produk
Route::get('/', function () {
    return redirect()->route('products.index');
});

// READ   - Daftar semua produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// CREATE - Form tambah produk baru
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// EDIT   - Form edit produk berdasarkan Firebase key
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
