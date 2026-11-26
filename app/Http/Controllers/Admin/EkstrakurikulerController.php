<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pembina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\EkstrakurikulerExport;
use Maatwebsite\Excel\Facades\Excel;

class EkstrakurikulerController extends Controller
{
    // 1. TAMPILKAN DATA
    public function index(Request $request)
    {
        $query = Ekstrakurikuler::with('pembina');

        // 1. Fitur Search (Nama ekskul, deskripsi, atau nama pembina)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('pembina', function ($qPembina) use ($search) {
                      $qPembina->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Fitur Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Fitur Urutan (A-Z / Z-A)
        $sortOrder = $request->get('sort', 'asc') === 'desc' ? 'desc' : 'asc';
        $query->orderBy('nama', $sortOrder);

        // 4. Paginasi + simpan parameter query URL
        $ekskuls = $query->paginate(10)->withQueryString();
        $pembinas = Pembina::all();

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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi logo
            'hari' => 'nullable|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
           'jam_mulai' => 'nullable|date_format:H:i:s',
'jam_selesai' => 'nullable|date_format:H:i:s|after:jam_mulai',
        ]);

        $data = $request->all();

        // Handle upload banner (foto)
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ekstrakurikuler/banner', 'public');
        }

        // Handle upload logo
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('ekstrakurikuler/logo', 'public');
        }

        Ekstrakurikuler::create($data);

        return redirect()->route('admin.adexstra')->with('success', 'Ekstrakurikuler berhasil ditambahkan!');
    }

    // 3. UPDATE DATA
    
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'kuota' => 'required|integer|min:1',
        'status' => 'required|in:aktif,nonaktif',
        'pembina_id' => 'nullable|exists:pembina,id',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'hari' => 'nullable|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        'tanggal_mulai' => 'nullable|date',
    'jam_mulai' => 'nullable|date_format:H:i',
'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
    ]);

    $ekskul = Ekstrakurikuler::findOrFail($id);

    // Pastikan pembina_id ikut disimpan
    $data = [
        'nama' => $validated['nama'],
        'deskripsi' => $validated['deskripsi'] ?? null,
        'kuota' => $validated['kuota'],
        'status' => $validated['status'],
        'pembina_id' => $validated['pembina_id'] ?? null,
        'hari' => $validated['hari'] ?? null,
        'tanggal_mulai' => $validated['tanggal_mulai'] ?? null,
        'jam_mulai' => $validated['jam_mulai'] ?? null,
        'jam_selesai' => $validated['jam_selesai'] ?? null,
    ];

    // Update foto banner
    if ($request->hasFile('foto')) {
        if ($ekskul->foto && Storage::disk('public')->exists($ekskul->foto)) {
            Storage::disk('public')->delete($ekskul->foto);
        }

        $data['foto'] = $request->file('foto')->store('ekstrakurikuler/banner', 'public');
    }

    // Update logo
    if ($request->hasFile('logo')) {
        if ($ekskul->logo && Storage::disk('public')->exists($ekskul->logo)) {
            Storage::disk('public')->delete($ekskul->logo);
        }

        $data['logo'] = $request->file('logo')->store('ekstrakurikuler/logo', 'public');
    }

    $ekskul->update($data);

    return redirect()
        ->route('admin.adexstra')
        ->with('success', 'Data ekstrakurikuler berhasil diperbarui!');
}


    // 4. HAPUS DATA
    public function destroy($id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
        
        // Hapus foto banner dari storage
        if ($ekskul->foto && Storage::disk('public')->exists($ekskul->foto)) {
            Storage::disk('public')->delete($ekskul->foto);
        }

        // Hapus logo dari storage
        if ($ekskul->logo && Storage::disk('public')->exists($ekskul->logo)) {
            Storage::disk('public')->delete($ekskul->logo);
        }

        $ekskul->delete();

        return redirect()->route('admin.adexstra')->with('success', 'Ekstrakurikuler berhasil dihapus!');
    }

    public function export(Request $request)
    {
        $namaFile = 'data-ekstrakurikuler-' . now()->format('Y-m-d-His') . '.xlsx';

        return Excel::download(
            new EkstrakurikulerExport(
                $request->search,
                $request->status,
                $request->sort ?? 'asc'
            ),
            $namaFile
        );
    }
}