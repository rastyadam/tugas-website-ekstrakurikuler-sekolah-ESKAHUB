<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function show()
    {
        return view('pembina.auth.password');
    }

 public function update(Request $request)
{
    $request->validate([
        'password' => 'required|min:8|confirmed',
    ]);

    $user = Auth::user();
    $user->update([
        'kata_sandi'           => Hash::make($request->password),
        'harus_ganti_password' => false, // ✅ WAJIB JADI FALSE
    ]);

    // Redirect sesuai role
    if ($user->peran === 'admin') {
        return redirect()->route('admin.dashboard')->with('success', 'Password berhasil diubah!');
    } 
    
    if ($user->peran === 'pembina') {
        return redirect()->route('pembina.dashboard-pembina')->with('success', 'Password berhasil diubah!');
    }
    
    return redirect()->route('student.beranda')->with('success', 'Password berhasil diubah!');
}
}