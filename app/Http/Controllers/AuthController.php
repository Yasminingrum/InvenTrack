<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function logout(Request $request)
    {
        $request->session()->forget([
            'firebase_uid',
            'firebase_email',
            'firebase_display_name',
            'firebase_role',
        ]);
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

     /**
     * Target continueUrl setelah user klik link verifikasi email dari Firebase.
     * Firebase redirect ke sini setelah email berhasil diverifikasi.
     */
    public function emailVerified(Request $request)
    {
        return redirect()->route('login')->with(
            'success',
            '✅ Email berhasil diverifikasi! Silakan login untuk melanjutkan.'
        );
    }

    /**
     * Simpan session setelah Firebase Auth berhasil di frontend.
     * Sekarang menerima 'role' dari frontend (dibaca dari Firebase DB).
     */
    public function storeSession(Request $request)
    {
        $request->validate([
            'uid'          => 'required|string',
            'email'        => 'required|email',
            'display_name' => 'nullable|string',
            'role'         => 'nullable|string|in:superadmin,admin,viewer',
        ]);

        $request->session()->put('firebase_uid',          $request->uid);
        $request->session()->put('firebase_email',        $request->email);
        $request->session()->put('firebase_display_name', $request->display_name ?? $request->email);
        $request->session()->put('firebase_role',         $request->role ?? 'viewer');

        return response()->json(['success' => true]);
    }
}
