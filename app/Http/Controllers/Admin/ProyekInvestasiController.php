<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProyekInvestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProyekInvestasiController extends Controller
{
    public function index()
    {
        $proyek = ProyekInvestasi::orderBy('urutan')->get();
        return view('admin.proyek_investasi_index', compact('proyek'));
    }

    public function create()
    {
        return view('admin.proyek_investasi_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'sektor' => 'required|string|max:100',
            'nilai_investasi' => 'nullable|numeric',
            'status' => 'required|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('proyek_investasi', 'public');
        }

        $data['urutan'] = ProyekInvestasi::max('urutan') + 1;

        ProyekInvestasi::create($data);

        return redirect()->route('admin.proyek-investasi.index')
            ->with('success', 'Proyek investasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $proyek = ProyekInvestasi::findOrFail($id);
        return view('admin.proyek_investasi_edit', compact('proyek'));
    }

    public function update(Request $request, $id)
    {
        $proyek = ProyekInvestasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'sektor' => 'required|string|max:100',
            'nilai_investasi' => 'nullable|numeric',
            'status' => 'required|string',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($proyek->gambar) {
                Storage::disk('public')->delete($proyek->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('proyek_investasi', 'public');
        }

        $proyek->update($data);

        return redirect()->route('admin.proyek-investasi.index')
            ->with('success', 'Proyek investasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $proyek = ProyekInvestasi::findOrFail($id);
        if ($proyek->gambar) {
            Storage::disk('public')->delete($proyek->gambar);
        }
        $proyek->delete();

        return redirect()->route('admin.proyek-investasi.index')
            ->with('success', 'Proyek investasi berhasil dihapus!');
    }

    public function updateOrder(Request $request)
    {
        $orders = $request->input('order', []);
        foreach ($orders as $index => $id) {
            ProyekInvestasi::where('id', $id)->update(['urutan' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }
}