<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\MemberSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // ================= LOGIN ADMIN =================
    public function showAdminLogin()
    {
        return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt([...$credentials, 'peran' => 'admin'])) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Kredensial tidak cocok atau Anda bukan Admin.',
        ])->onlyInput('email');
    }

    // ================= LOGIN SISWA =================
    public function showSiswaLogin()
    {
        return view('student.login-siswa');
    }

    public function siswaLogin(Request $request)
    {
        $request->validate([
            'nisn'     => ['required', 'string'],
            'password' => ['required'],
        ]);

        $member = MemberSiswa::with('pengguna')
            ->where('nisn', $request->nisn)
            ->first();

        if ($member && $member->pengguna) {
            if (Hash::check($request->password, $member->pengguna->kata_sandi)) {
                Auth::login($member->pengguna);
                $request->session()->regenerate();
                return redirect()->intended(route('student.beranda'));
            }
        }

        return back()->withErrors([
            'nisn' => 'NISN atau Password salah.',
        ])->onlyInput('nisn');
    }


        // ================= LOGIN PEMBINA =================
    public function showPembinaLogin()
    {
        // Sesuaikan dengan nama file blade kamu, misal: auth.login-pembina
       return view('pembina.auth.login-pembina');
    }

    public function pembinaLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah email & password cocok, DAN role-nya 'pembina'
        if (Auth::attempt([...$credentials, 'peran' => 'pembina'], $request->has('remember'))) {
            $request->session()->regenerate();
            
            // Jika sukses, arahkan ke dashboard pembina (nanti kita buat)
            // Sementara arahkan ke halaman ganti password karena harus_ganti_password = true
            return redirect()->route('password.force'); 
        }

        return back()->withErrors([
            'email' => 'Kredensial tidak cocok atau Anda bukan Pembina.',
        ])->onlyInput('email');
    }

    // ================= REGISTRASI SISWA =================
    public function showRegister()
    {
        return view('student.register');
    }

    // Cek NISN via AJAX (simulasi API sekolah)
        // Cek NISN via AJAX (Ambil dari Database)
  public function cekNisn(Request $request)
{
    $request->validate(['nisn' => 'required']);

    $student = MemberSiswa::where('nisn', $request->nisn)->first();

    if (!$student) {
        return back()->with('error', 'NISN tidak ditemukan di database sekolah.')->withInput();
    }

    // Kalau NISN ditemukan, kita balikin ke view register
    // Bawa variabel $student dan status 'sudah_terdaftar'
    $sudahTerdaftar = $student->pengguna_id !== null;

    return view('student.register', compact('student', 'sudahTerdaftar'));
}

   public function register(Request $request)
{
    $request->validate([
        'student_id' => 'required',
        'password'   => 'required|min:8|confirmed',
    ]);

    $siswa = MemberSiswa::findOrFail($request->student_id);

    if ($siswa->pengguna_id !== null) {
        return back()->with('error', 'NISN ini sudah terdaftar.');
    }

    DB::transaction(function () use ($request, $siswa) {
        // 1. Buat Akun Pengguna (Nama, Email, dll diambil dari data siswa)
        $pengguna = Pengguna::create([
            'nama'       => $siswa->nama,
            'email'      => $siswa->email ?? $siswa->nisn . '@siswa.sch.id', // Fallback kalau email kosong
            'username'   => $siswa->nisn,
            'kata_sandi' => Hash::make($request->password),
            'peran'      => 'siswa',
        ]);

        // 2. Update member_siswa dengan pengguna_id baru
        $siswa->update([
            'pengguna_id' => $pengguna->id,
        ]);
    });

    return redirect()->route('student.login')
        ->with('success', 'Akun berhasil dibuat! Silakan login.');
}

   // ================= LOGOUT =================
public function logout(Request $request)
{
    // Ambil data pengguna sebelum logout
    $user = Auth::user();

    // Tentukan halaman login berdasarkan peran
    $redirect = match ($user->peran ?? null) {
        'admin'  => route('admin.login'),
        'pembina' => route('login.pembina'),
        'siswa'  => route('student.login'),
        default  => route('student.login'),
    };

    // Logout pengguna
    Auth::logout();

    // Hapus session
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Kembali ke halaman login sesuai role
    return redirect($redirect);
}
}