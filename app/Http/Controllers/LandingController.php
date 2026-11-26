<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;

class LandingController extends Controller
{
    public function index()
    {
        $ekskuls = Ekstrakurikuler::where('status', 'aktif')
            ->latest()
            ->take(6)
            ->get();

        return view('landing.index', compact('ekskuls'));
    }
}
