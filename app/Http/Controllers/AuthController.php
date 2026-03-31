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
     * Simpan session setelah Firebase Auth berhasil di frontend.
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
