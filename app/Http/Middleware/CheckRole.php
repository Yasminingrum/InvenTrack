<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Cek apakah user memiliki role yang diizinkan.
     * Penggunaan: ->middleware('role:superadmin,admin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $userRole = $request->session()->get('firebase_role', 'viewer');

        if (!in_array($userRole, $roles)) {
            // Jika AJAX request
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Akses ditolak.'], 403);
            }

            // Redirect dengan pesan error
            return redirect()->route('products.index')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
