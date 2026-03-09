<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Tampilkan halaman daftar produk (Read - semua data dari Firebase via JavaScript).
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Tampilkan form tambah produk.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Tampilkan form edit produk berdasarkan Firebase key ID.
     * Data diambil langsung dari Firebase via JavaScript di sisi frontend.
     */
    public function edit($id)
    {
        return view('products.edit', compact('id'));
    }

    /**
     * NOTE: Create, Update, Delete dilakukan langsung dari browser
     * ke Firebase Realtime Database REST API menggunakan JavaScript (fetch).
     * Tidak ada proses di server-side Laravel untuk operasi tersebut.
     *
     * Endpoint Firebase yang digunakan:
     *  - GET    /products.json           → Read semua produk
     *  - POST   /products.json           → Create produk baru (Firebase generate ID)
     *  - GET    /products/{id}.json      → Read satu produk
     *  - PATCH  /products/{id}.json      → Update produk
     *  - DELETE /products/{id}.json      → Delete produk
     */
}
