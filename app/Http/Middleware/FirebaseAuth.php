<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuth
{
    /**
     * Cek apakah user sudah login (session Firebase ada).
     * Jika belum, redirect ke halaman login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('firebase_uid')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
