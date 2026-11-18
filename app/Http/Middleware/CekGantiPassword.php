<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekGantiPassword
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->harus_ganti_password) {
            // Kecuali dia sedang di halaman ganti-password atau logout
            if (!$request->routeIs('password.force') && !$request->routeIs('password.update') && !$request->routeIs('logout')) {
                return redirect()->route('password.force');
            }
        }

        return $next($request);
    }
}