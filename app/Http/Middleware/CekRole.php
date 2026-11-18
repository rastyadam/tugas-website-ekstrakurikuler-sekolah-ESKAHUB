<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kalau belum login, lempar ke login umum
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Kalau role user nggak ada di daftar role yang diizinkan
        if (!in_array(Auth::user()->peran, $roles)) {
            // Tendang ke halaman login yang sesuai role-nya
            if (Auth::user()->peran === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->peran === 'pembina') {
                return redirect()->route('pembina.dashboard-pembina');
            } else {
                return redirect()->route('student.beranda');
            }
        }

        return $next($request);
    }
}