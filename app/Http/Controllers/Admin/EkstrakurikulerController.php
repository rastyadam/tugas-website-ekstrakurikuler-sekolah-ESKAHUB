<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pembina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    // 1. TAMPILKAN DATA
    public function index()
{
    // Ambil data ekskul beserta relasinya
    $ekskuls = \App\Models\Ekstrakurikuler::with('pembina')->latest()->paginate(10);
    
    // ✅ Hitung jumlah pendaftar (pending + diterima) untuk setiap ekskul
    foreach ($ekskuls as $ekskul) {
        $ekskul->terisi = \App\Models\Pendaftaran::where('ekstrakurikuler_id', $ekskul->id)
            ->whereIn('status', ['pending', 'diterima'])
            ->count();
    }

    // Ambil data pembina buat dropdown form
    $pembinas = \App\Models\Pembina::all();

    return view('admin.adexstra', compact('ekskuls', 'pembinas'));
}

    // 2. SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
            'status' => 'required|in:aktif,nonaktif',
            'pembina_id' => 'nullable|exists:pembina,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Handle upload foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ekstrakurikuler', 'public');
        }

        Ekstrakurikuler::create($data);

        return redirect()->route('admin.adexstra')->with('success', 'Ekstrakurikuler berhasil ditambahkan!');
    }

    // 3. UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
            'status' => 'required|in:aktif,nonaktif',
            'pembina_id' => 'nullable|exists:pembina,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $ekskul = Ekstrakurikuler::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($ekskul->foto && Storage::disk('public')->exists($ekskul->foto)) {
                Storage::disk('public')->delete($ekskul->foto);
            }
            $data['foto'] = $request->file('foto')->store('ekstrakurikuler', 'public');
        }

        $ekskul->update($data);

        return redirect()->route('admin.adexstra')->with('success', 'Data berhasil diperbarui!');
    }

    // 4. HAPUS DATA
    public function destroy($id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
        
        // Hapus foto dari storage jika ada
        if ($ekskul->foto && Storage::disk('public')->exists($ekskul->foto)) {
            Storage::disk('public')->delete($ekskul->foto);
        }

        $ekskul->delete();

        return redirect()->route('admin.adexstra')->with('success', 'Ekstrakurikuler berhasil dihapus!');
    }


    
}