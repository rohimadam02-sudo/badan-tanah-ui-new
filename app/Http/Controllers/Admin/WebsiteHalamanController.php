<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Halaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WebsiteHalamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $halamans = Halaman::all();
        return view('admin.halaman_index', compact('halamans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.halaman_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'struktur_organisasi' => 'nullable|string',
            'dasar_hukum' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data = $request->all();

        // Generate slug
        $data['slug'] = Str::slug($request->judul);

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('halaman', 'public');
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('halaman', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        Halaman::create($data);

        return redirect()
            ->route('admin.halaman.index')
            ->with('success', 'Halaman berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $halaman = Halaman::findOrFail($id);
        return view('admin.halaman_edit_umum', compact('halaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $halaman = Halaman::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'struktur_organisasi' => 'nullable|string',
            'dasar_hukum' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data = $request->except(['gambar', 'foto']);

        // Update slug jika judul berubah
        if ($halaman->judul != $request->judul) {
            $data['slug'] = Str::slug($request->judul);
        }

        // Upload gambar hero
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            if ($halaman->gambar) {
                Storage::disk('public')->delete($halaman->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('halaman', 'public');
        }

        // Upload foto tambahan
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            if ($halaman->foto) {
                Storage::disk('public')->delete($halaman->foto);
            }
            $data['foto'] = $request->file('foto')->store('halaman', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $halaman->update($data);

        // Log aktivitas
        activity()
            ->performedOn($halaman)
            ->causedBy(auth()->user())
            ->event('updated')
            ->log('memperbarui halaman "' . $halaman->judul . '"');

        return redirect()
            ->route('admin.halaman.index')
            ->with('success', 'Halaman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $halaman = Halaman::findOrFail($id);

        // Hapus gambar
        if ($halaman->gambar) {
            Storage::disk('public')->delete($halaman->gambar);
        }
        if ($halaman->foto) {
            Storage::disk('public')->delete($halaman->foto);
        }

        $halaman->delete();

        return redirect()
            ->route('admin.halaman.index')
            ->with('success', 'Halaman berhasil dihapus!');
    }

    /**
     * Toggle active status
     */
    public function toggle($id)
    {
        $halaman = Halaman::findOrFail($id);
        $halaman->is_active = !$halaman->is_active;
        $halaman->save();

        return response()->json([
            'success' => true,
            'is_active' => $halaman->is_active,
            'message' => $halaman->is_active ? 'Halaman diaktifkan' : 'Halaman dinonaktifkan'
        ]);
    }
}