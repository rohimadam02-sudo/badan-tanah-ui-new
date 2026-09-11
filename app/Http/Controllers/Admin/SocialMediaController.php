<?php

/* =========================================================
    NAMESPACE & IMPORT
========================================================= */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

/* =========================================================
    CONTROLLER: SOCIAL MEDIA
========================================================= */
class SocialMediaController extends Controller
{
    /* =========================================================
        DAFTAR SOCIAL MEDIA
    ========================================================= */
    public function index()
    {
        $socialMedias = SocialMedia::ordered()->get();
        return view('admin.social_media_index', compact('socialMedias'));
    }

    /* =========================================================
        FORM TAMBAH SOCIAL MEDIA
    ========================================================= */
    public function create()
    {
        return view('admin.social_media_create');
    }

    /* =========================================================
        SIMPAN SOCIAL MEDIA BARU
    ========================================================= */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'warna' => 'nullable|string|max:7',
        ]);

        $maxUrutan = SocialMedia::max('urutan') ?? 0;

        SocialMedia::create([
            'nama' => $request->nama,
            'icon' => $request->icon,
            'url' => $request->url,
            'warna' => $request->warna ?? null,
            'is_active' => $request->has('is_active'),
            'urutan' => $maxUrutan + 1,
        ]);

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Social media berhasil ditambahkan!');
    }

    /* =========================================================
        FORM EDIT SOCIAL MEDIA
    ========================================================= */
    public function edit($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        return view('admin.social_media_edit', compact('socialMedia'));
    }

    /* =========================================================
        UPDATE SOCIAL MEDIA
    ========================================================= */
    public function update(Request $request, $id)
    {
        $socialMedia = SocialMedia::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'warna' => 'nullable|string|max:7',
        ]);

        $socialMedia->update([
            'nama' => $request->nama,
            'icon' => $request->icon,
            'url' => $request->url,
            'warna' => $request->warna ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Social media berhasil diperbarui!');
    }

    /* =========================================================
        HAPUS SOCIAL MEDIA
    ========================================================= */
    public function destroy($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->delete();

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Social media berhasil dihapus!');
    }

    /* =========================================================
        TOGGLE STATUS AKTIF
    ========================================================= */
    public function toggle($id)
    {
        $socialMedia = SocialMedia::findOrFail($id);
        $socialMedia->is_active = !$socialMedia->is_active;
        $socialMedia->save();

        return response()->json([
            'success' => true,
            'is_active' => $socialMedia->is_active,
        ]);
    }

    /* =========================================================
        UPDATE URUTAN SOCIAL MEDIA
    ========================================================= */
    public function updateOrder(Request $request)
    {
        $orders = $request->input('order', []);

        foreach ($orders as $index => $id) {
            SocialMedia::where('id', $id)->update(['urutan' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}