<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembina; // Ini nama Model-nya tetap Pembina karena nempel ke tabel 'pembina'
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class pelatihController extends Controller
{
    // 1. TAMPILKAN DATA PELATIH
   public function index()
{
    $pelatih = Pembina::with(['pengguna', 'ekstrakurikuler'])
        ->latest()
        ->paginate(10);

    return view('admin.pelatih', compact('pelatih'));
}

    // 2. SIMPAN DATA PELATIH BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:8',
            'jenis_pembina' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'asal' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // A. Buat Akun Pengguna
            $pengguna = Pengguna::create([
                'nama'                 => $request->nama,
                'email'                => $request->email,
                'kata_sandi'           => Hash::make($request->password),
                'peran'                => 'pembina', // Peran di DB tetap pembina
                'harus_ganti_password' => true,
            ]);

            // B. Buat Profil di tabel pembina
            Pembina::create([
                'user_id'       => $pengguna->id,
                'nama'          => $request->nama,
                'jenis_pembina' => $request->jenis_pembina,
                'no_hp'         => $request->no_hp,
                'asal'          => $request->asal,
            ]);
        });

        return redirect()->route('admin.pelatih')->with('success', 'Data Pelatih & Akun berhasil ditambahkan!');
    }

    // 3. UPDATE DATA PELATIH
    public function update(Request $request, $id)
{
    $pembina = Pembina::findOrFail($id);

    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:pengguna,email,' . $pembina->user_id,
        'jenis_pembina' => 'nullable|string',
        'no_hp' => 'nullable|string|max:20',
        'asal' => 'nullable|string|max:255',
        'password' => 'nullable|min:8',
    ]);

    DB::transaction(function () use ($request, $pembina) {
        $dataPengguna = [
            'nama'  => $request->nama,
            'email' => $request->email,
        ];
        
        if ($request->filled('password')) {
            $dataPengguna['kata_sandi'] = Hash::make($request->password);
        }

        $pembina->pengguna->update($dataPengguna);

        $pembina->update([
            'nama'          => $request->nama,
            'jenis_pembina' => $request->jenis_pembina,
            'no_hp'         => $request->no_hp,
            'asal'          => $request->asal,
        ]);
    });

    return redirect()->route('admin.pelatih')->with('success', 'Data Pembina berhasil diperbarui!');
}

    // 4. HAPUS DATA PELATIH
    public function destroy($id)
    {
        $pelatih = Pembina::findOrFail($id);
        $user_id = $pelatih->user_id;
        
        $pelatih->delete();
        Pengguna::where('id', $user_id)->delete();

        return redirect()->route('admin.pelatih')->with('success', 'Pelatih & Akun berhasil dihapus!');
    }
}