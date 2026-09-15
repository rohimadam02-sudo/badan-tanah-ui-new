<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class WebsiteBuilderController extends Controller
{
    public function edit()
    {
        $pengaturan = PengaturanWebsite::first();
        return view('admin.website', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = PengaturanWebsite::first();
        if (!$pengaturan) {
            $pengaturan = new PengaturanWebsite();
        }

        $request->validate([
            'judul_hero' => 'required',
            'subjudul_hero' => 'required',
            'tombol_text' => 'required',
            'tombol_link' => 'required',
        ]);

        $pengaturan->judul_hero = $request->judul_hero;
        $pengaturan->subjudul_hero = $request->subjudul_hero;
        $pengaturan->tombol_text = $request->tombol_text;
        $pengaturan->tombol_link = $request->tombol_link;
        $pengaturan->warna_utama = $request->warna_utama ?? '#0B2A4A';
        $pengaturan->warna_sekunder = $request->warna_sekunder ?? '#1D4ED8';
        $pengaturan->save();

        return redirect()->route('admin.website')->with('success', 'Pengaturan website berhasil diubah!');
    }
}