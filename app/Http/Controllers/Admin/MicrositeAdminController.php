<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Microsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MicrositeAdminController extends Controller
{
    public function index()
    {
        $microsites = Microsite::latest()->get();
        return view('admin.microsite_index', compact('microsites'));
    }

    public function create()
    {
        return view('admin.microsite_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
        ]);

        $data = $request->all();

        // Upload gambar
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $file = $request->file('gambar');
            $filename = 'microsite_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $data['gambar'] = $file->storeAs('microsites', $filename, 'public');
        }

        $data['slug'] = Str::slug($request->judul);
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        Microsite::create($data);

        return redirect()->route('admin.microsite.index')
            ->with('success', 'Microsite berhasil dibuat!');
    }

    public function edit($id)
    {
        $microsite = Microsite::findOrFail($id);
        return view('admin.microsite_edit', compact('microsite'));
    }

    public function update(Request $request, $id)
    {
        $microsite = Microsite::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after:tanggal_mulai',
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
        ]);

        $data = $request->except(['gambar']);

        // Upload gambar baru
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            if ($microsite->gambar) {
                Storage::disk('public')->delete($microsite->gambar);
            }
            $file = $request->file('gambar');
            $filename = 'microsite_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $data['gambar'] = $file->storeAs('microsites', $filename, 'public');
        }

        // Update slug jika judul berubah
        if ($microsite->judul != $request->judul) {
            $data['slug'] = Str::slug($request->judul);
        }

        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $microsite->update($data);

        return redirect()->route('admin.microsite.index')
            ->with('success', 'Microsite berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $microsite = Microsite::findOrFail($id);

        if ($microsite->gambar) {
            Storage::disk('public')->delete($microsite->gambar);
        }

        $microsite->delete();

        return redirect()->route('admin.microsite.index')
            ->with('success', 'Microsite berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $microsite = Microsite::findOrFail($id);
        $microsite->is_active = !$microsite->is_active;
        $microsite->save();

        return response()->json([
            'success' => true,
            'is_active' => $microsite->is_active,
        ]);
    }
}