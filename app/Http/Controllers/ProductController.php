<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * READ — Tampilkan halaman daftar produk.
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * CREATE — Tampilkan form tambah produk.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * VIEW — Tampilkan halaman detail satu produk.
     * Data diambil dari Firebase via JavaScript di frontend.
     */
    public function show($id)
    {
        return view('products.show', compact('id'));
    }

    /**
     * UPDATE — Tampilkan form edit produk berdasarkan Firebase key ID.
     * Data diambil langsung dari Firebase via JavaScript di sisi frontend.
     */
    public function edit($id)
    {
        return view('products.edit', compact('id'));
    }
}
