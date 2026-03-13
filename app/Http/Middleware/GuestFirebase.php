<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestFirebase
{
    /**
     * Jika user sudah login (session Firebase ada),
     * redirect ke dashboard — tidak perlu login lagi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('firebase_uid')) {
            return redirect()->route('products.index');
        }

        return $next($request);
    }
}
