<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function loginPage()
    {
        return view('auth.login');
    }

    /**
     * Tampilkan halaman register.
     */
    public function registerPage()
    {
        return view('auth.register');
    }

    /**
     * Proses logout — hapus session dan redirect ke login.
     * (Login/Register diproses di frontend via Firebase JS SDK)
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['firebase_uid', 'firebase_email', 'firebase_display_name']);
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Simpan session setelah Firebase Auth berhasil di frontend.
     * Dipanggil via AJAX dari halaman login/register.
     */
    public function storeSession(Request $request)
    {
        $request->validate([
            'uid'          => 'required|string',
            'email'        => 'required|email',
            'display_name' => 'nullable|string',
        ]);

        $request->session()->put('firebase_uid',          $request->uid);
        $request->session()->put('firebase_email',        $request->email);
        $request->session()->put('firebase_display_name', $request->display_name ?? $request->email);

        return response()->json(['success' => true]);
    }
}
