<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanWebsite::first();
        return view('admin.pengaturan', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul_hero' => 'nullable|string|max:255',
            'subjudul_hero' => 'nullable|string',
            'tombol_text' => 'nullable|string|max:100',
            'tombol_link' => 'nullable|string|max:100',
            'warna_utama' => 'nullable|string|max:7',
            'warna_sekunder' => 'nullable|string|max:7',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $pengaturan = PengaturanWebsite::first();
        if (!$pengaturan) {
            $pengaturan = new PengaturanWebsite();
        }

        $pengaturan->judul_hero = $request->judul_hero;
        $pengaturan->subjudul_hero = $request->subjudul_hero;
        $pengaturan->tombol_text = $request->tombol_text;
        $pengaturan->tombol_link = $request->tombol_link;
        $pengaturan->warna_utama = $request->warna_utama ?? '#0B2A4A';
        $pengaturan->warna_sekunder = $request->warna_sekunder ?? '#1D4ED8';

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logo', 'public');
            $pengaturan->logo = $path;
        }

        $pengaturan->save();

        return redirect()->route('admin.pengaturan')->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}