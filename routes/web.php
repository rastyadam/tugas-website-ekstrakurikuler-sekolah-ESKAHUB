<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\Admin\EkstrakurikulerController as AdminEkstrakurikulerController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\pelatihController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Pembina\DashboardController as PembinaDashboard;
use App\Http\Controllers\Pembina\LaporanController as PembinaLaporanController;
use App\Http\Controllers\Siswa\BerandaController;
use App\Http\Controllers\Siswa\EkstrakurikulerController as SiswaEkstrakurikulerController;
use App\Http\Controllers\Siswa\PendaftaranController;
use Illuminate\Support\Facades\Route;

// =========================
// ADMIN
// =========================
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.process');
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::view('/datasiswa', 'admin.datasiswa')->name('datasiswa.index');
    Route::get('/data-siswa/export', [DataSiswaController::class, 'export'])->name('datasiswa.export');
    Route::get('/adexstra', [AdminEkstrakurikulerController::class, 'index'])->name('adexstra');
    Route::post('/adexstra', [AdminEkstrakurikulerController::class, 'store'])->name('adexstra.store');
    Route::get('/adexstra/export', [AdminEkstrakurikulerController::class, 'export'])
        ->name('adexstra.export');
    Route::put('/adexstra/{id}', [AdminEkstrakurikulerController::class, 'update'])->name('adexstra.update');
    Route::delete('/adexstra/{id}', [AdminEkstrakurikulerController::class, 'destroy'])->name('adexstra.destroy');
 
    Route::get('/pembina', [pelatihController::class, 'index'])->name('pelatih');
    Route::post('/pembina', [pelatihController::class, 'store'])->name('pelatih.store');
    Route::put('/pembina/{id}', [pelatihController::class, 'update'])->name('pelatih.update');
    Route::delete('/pembina/{id}', [pelatihController::class, 'destroy'])->name('pelatih.destroy');
Route::get('/datasiswa/export', [SiswaController::class, 'export'])->name('datasiswa.export');
     Route::get('/datasiswa', [SiswaController::class, 'index'])->name('datasiswa.index');
    Route::post('/datasiswa/import', [SiswaController::class, 'import'])->name('datasiswa.import');
Route::get('/datasiswa/{id}', [SiswaController::class, 'show'])->name('datasiswa.show');

   Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
   Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::put('/profil/update', [ProfilController::class, 'updateProfil'])->name('profil.update');
Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');


});


// =========================
// PEMBINA
// =========================
Route::get('/login-pembina', [AuthController::class, 'showPembinaLogin'])->name('login.pembina');
Route::post('/login-pembina', [AuthController::class, 'pembinaLogin'])->name('login.pembina.store');

// ✅ Tambahkan 'role:pembina'
Route::middleware(['auth', 'wajib.ganti', 'role:pembina'])->prefix('pembina')->name('pembina.')->group(function () {
    Route::get('/dashboard', [PembinaDashboard::class, 'index'])->name('dashboard-pembina');
    Route::get('/pendaftar', [PembinaDashboard::class, 'pendaftar'])->name('pendaftar');
    Route::put('/pendaftar/{id}/status', [PembinaDashboard::class, 'updateStatus'])->name('pendaftar.update-status');
     // Atur Jadwal Seleksi
    Route::post('/pendaftar/{id}/jadwal', [PembinaDashboard::class, 'simpanJadwalSeleksi'])->name('pendaftar.jadwal');
    
    // Terima Langsung (Tanpa Seleksi)
    Route::put('/pendaftar/{id}/terima-langsung', [PembinaDashboard::class, 'terimaLangsung'])->name('pendaftar.terima-langsung');
    Route::post('/pengumuman', [PembinaDashboard::class, 'simpanPengumuman'])->name('pengumuman.store');
    
        // Halaman Atur Jadwal Latihan
    Route::get('/jadwal-latihan', [PembinaDashboard::class, 'jadwalLatihan'])->name('jadwal-latihan');
    Route::post('/jadwal-latihan/{id}', [PembinaDashboard::class, 'simpanJadwalLatihan'])->name('jadwal-latihan.store');


    // Halaman Kelola Pengumuman
    Route::get('/pengumuman', [PembinaDashboard::class, 'pengumuman'])->name('pengumuman');
    // Simpan Pengumuman
    Route::post('/pengumuman', [PembinaDashboard::class, 'simpanPengumuman'])->name('pengumuman.store');

       Route::get('/anggota', [PembinaDashboard::class, 'anggota'])->name('anggota');

       Route::get('/anggota/export', [PembinaDashboard::class, 'exportAnggota'])->name('anggota.export');

Route::get('/laporan', [PembinaLaporanController::class, 'index'])
    ->name('laporan');

    Route::get('/laporan/pdf', [PembinaLaporanController::class, 'exportPdf'])
    ->name('laporan.pdf');

// Profil Pembina
Route::get('/profil', [PembinaDashboard::class, 'profil'])->name('profil');
Route::put('/profil/update', [PembinaDashboard::class, 'updateProfil'])->name('profil.update');
Route::put('/profil/password', [PembinaDashboard::class, 'updatePassword'])->name('profil.password');


});

   

// =========================
// SISWA: LOGIN & REGISTER
// =========================
Route::get('/login', [AuthController::class, 'showSiswaLogin'])->name('student.login');
Route::post('/login', [AuthController::class, 'siswaLogin'])->name('student.login.process');

Route::get('/register', [AuthController::class, 'showRegister'])->name('student.register');
Route::post('/register/validate', [AuthController::class, 'cekNisn'])->name('student.register.validate');
Route::post('/register', [AuthController::class, 'register'])->name('student.register.store');


// =========================
// SISWA: HALAMAN DALAM
// =========================
// ✅ Tambahkan 'role:siswa'
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('student.')->group(function () {
    
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::view('/pengumuman', 'student.pengumuman')->name('pengumuman');
    
    Route::get('/ekstra', [SiswaEkstrakurikulerController::class, 'index'])->name('ekstra');
    Route::get('/ekstra/{id}/form-daftar', [SiswaEkstrakurikulerController::class, 'showFormDaftar'])->name('ekstra.form-daftar');
    Route::post('/ekstra/{id}/daftar', [SiswaEkstrakurikulerController::class, 'daftar'])->name('ekstra.daftar');
    
    Route::get('/ekstra/{id}', [SiswaEkstrakurikulerController::class, 'show'])->name('ekstra.detail');
    
    
   Route::get('/profil', [BerandaController::class, 'profil'])->name('profil');
    Route::get('/pendaftaran-saya/{id}', [PendaftaranController::class, 'show'])->name('pendaftaran-saya.detail');
    Route::get('/pendaftaran-saya', [PendaftaranController::class, 'index'])->name('pendaftaran-saya');
    Route::view('/pendaftaran-saya/menunggu', 'student.pendaftaran-saya-detail-menunggu')->name('pendaftaran-saya-menunggu');
    Route::view('/pendaftaran-saya/diterima', 'student.pendaftaran-saya-detail-diterima')->name('pendaftaran-saya-diterima');
    Route::view('/pendaftaran-saya/tolak', 'student.pendaftaran-saya-detail-tolak')->name('pendaftaran-saya-tolak');
    
    Route::get('/pengumuman-saya', [\App\Http\Controllers\Siswa\PendaftaranController::class, 'pengumumanSaya'])->name('pengumuman-saya');
});


// =========================
// LUPA PASSWORD
// =========================
Route::get('/forgot-password', function () {
    return "Halaman Lupa Password belum tersedia.";
})->name('password.request');


// =========================
// GANTI PASSWORD
// =========================
Route::middleware(['auth'])->group(function () {
    Route::get('/ganti-password', [PasswordController::class, 'show'])->name('password.force');
    Route::post('/ganti-password', [PasswordController::class, 'update'])->name('password.update');
});


// =========================
// LOGOUT
// =========================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');