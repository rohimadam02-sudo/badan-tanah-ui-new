<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LokasiKantor;
use Illuminate\Http\Request;

class LokasiKantorController extends Controller
{
    public function index()
    {
        $lokasi = LokasiKantor::ordered()->get();
        return view('admin.lokasi_kantor_index', compact('lokasi'));
    }

    public function create()
    {
        return view('admin.lokasi_kantor_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'telepon' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'warna' => 'nullable|string|max:7',
        ]);

        $maxUrutan = LokasiKantor::max('urutan') ?? 0;

        // Jika di-set sebagai utama, unset utama yang lain
        if ($request->has('is_utama')) {
            LokasiKantor::where('is_utama', true)->update(['is_utama' => false]);
        }

        LokasiKantor::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'icon' => $request->icon ?? 'fa-building',
            'warna' => $request->warna ?? '#006400',
            'urutan' => $maxUrutan + 1,
            'is_active' => $request->has('is_active'),
            'is_utama' => $request->has('is_utama'),
            'deskripsi' => $request->deskripsi,
            'jam_kerja' => $request->jam_kerja,
        ]);

        return redirect()->route('admin.lokasi-kantor.index')
            ->with('success', 'Lokasi kantor berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $lokasi = LokasiKantor::findOrFail($id);
        return view('admin.lokasi_kantor_edit', compact('lokasi'));
    }

    public function update(Request $request, $id)
    {
        $lokasi = LokasiKantor::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'telepon' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'warna' => 'nullable|string|max:7',
        ]);

        if ($request->has('is_utama') && !$lokasi->is_utama) {
            LokasiKantor::where('is_utama', true)->update(['is_utama' => false]);
        }

        $lokasi->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'icon' => $request->icon ?? 'fa-building',
            'warna' => $request->warna ?? '#006400',
            'is_active' => $request->has('is_active'),
            'is_utama' => $request->has('is_utama'),
            'deskripsi' => $request->deskripsi,
            'jam_kerja' => $request->jam_kerja,
        ]);

        return redirect()->route('admin.lokasi-kantor.index')
            ->with('success', 'Lokasi kantor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lokasi = LokasiKantor::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('admin.lokasi-kantor.index')
            ->with('success', 'Lokasi kantor berhasil dihapus!');
    }

    public function toggle($id)
    {
        $lokasi = LokasiKantor::findOrFail($id);
        $lokasi->is_active = !$lokasi->is_active;
        $lokasi->save();

        return response()->json([
            'success' => true,
            'is_active' => $lokasi->is_active,
        ]);
    }

    public function updateOrder(Request $request)
    {
        $orders = $request->input('order', []);

        foreach ($orders as $index => $id) {
            LokasiKantor::where('id', $id)->update(['urutan' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}