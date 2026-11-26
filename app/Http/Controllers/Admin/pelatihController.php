<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembina;
use App\Models\Pengguna;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class pelatihController extends Controller
{
    // 1. TAMPILKAN DATA PELATIH (Hanya ada SATU fungsi index)
    public function index(Request $request)
    {
        $query = Pembina::with(['pengguna', 'ekstrakurikuler']);

        // 1. Fitur Search (Nama, Email, No HP, atau Ekstrakurikuler Diampu)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhereHas('pengguna', function ($qUser) use ($search) {
                      $qUser->where('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('ekstrakurikuler', function ($qEkskul) use ($search) {
                      $qEkskul->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Filter Tab / Status
        if ($request->get('tab') === 'aktif') {
            $query->has('ekstrakurikuler');
        } elseif ($request->get('tab') === 'nonaktif') {
            $query->doesntHave('ekstrakurikuler');
        }

        // 3. Urutan (A - Z / Z - A / Terbaru)
        $sort = $request->get('sort', 'asc');
        if ($sort === 'desc') {
            $query->orderBy('nama', 'desc');
        } elseif ($sort === 'latest') {
            $query->latest();
        } else {
            $query->orderBy('nama', 'asc');
        }

        $pelatih = $query->paginate(10)->withQueryString();

        // 4. Statistik Ringkasan untuk Tab & Info Bar
        $totalPersonil  = Pembina::count();
        $aktifBertugas  = Pembina::has('ekstrakurikuler')->count();
        $belumDitugaskan = max(0, $totalPersonil - $aktifBertugas);

        $totalUnit = class_exists(Ekstrakurikuler::class) ? Ekstrakurikuler::count() : 0;
        $unitTerisi = class_exists(Ekstrakurikuler::class) ? Ekstrakurikuler::whereNotNull('pembina_id')->count() : 0;
        $rasioPengampu = $totalUnit > 0 ? round(($unitTerisi / $totalUnit) * 100) : 100;

        return view('admin.pelatih', compact(
            'pelatih',
            'totalPersonil',
            'aktifBertugas',
            'belumDitugaskan',
            'totalUnit',
            'rasioPengampu'
        ));
    }

    // 2. SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:pengguna,email',
            'password'      => 'required|min:8',
            'jenis_pembina' => 'nullable|string',
            'no_hp'         => 'nullable|string|max:20',
            'asal'          => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $pengguna = Pengguna::create([
                'nama'                 => $request->nama,
                'email'                => $request->email,
                'kata_sandi'           => Hash::make($request->password),
                'peran'                => 'pembina',
                'harus_ganti_password' => true,
            ]);

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

    // 3. UPDATE DATA
    public function update(Request $request, $id)
    {
        $pembina = Pembina::findOrFail($id);

        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|unique:pengguna,email,' . $pembina->user_id,
            'jenis_pembina' => 'nullable|string',
            'no_hp'         => 'nullable|string|max:20',
            'asal'          => 'nullable|string|max:255',
            'password'      => 'nullable|min:8',
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

    // 4. HAPUS DATA
    public function destroy($id)
    {
        $pelatih = Pembina::findOrFail($id);
        $user_id = $pelatih->user_id;

        $pelatih->delete();
        Pengguna::where('id', $user_id)->delete();

        return redirect()->route('admin.pelatih')->with('success', 'Pelatih & Akun berhasil dihapus!');
    }
}