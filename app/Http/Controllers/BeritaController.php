<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        // HANYA AMBIL BERITA YANG SUDAH DIPUBLIKASIKAN
        $berita = Berita::where('status', 'Dipublikasikan')->latest()->get();

        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.publications', compact('berita', 'menuNavigasi', 'pengaturan'));
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id);

        // HANYA BISA DIAKSES JIKA BERITA SUDAH DIPUBLIKASIKAN
        if ($berita->status != 'Dipublikasikan') {
            abort(404, 'Berita tidak ditemukan');
        }

        $berita->increment('views');

        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.berita_detail', compact('berita', 'menuNavigasi', 'pengaturan'));
    }
}