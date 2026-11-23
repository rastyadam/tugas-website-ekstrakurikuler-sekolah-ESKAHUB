<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $user->id,
            'username' => 'required|string|max:255|unique:pengguna,username,' . $user->id,
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

   public function updatePassword(Request $request)
    {
        $request->validate([
            'kata_sandi' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->update([
            'kata_sandi' => Hash::make($request->kata_sandi),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}