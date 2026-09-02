<?php

namespace App\Http\Controllers;

use App\Models\AsetTanah;
use App\Models\Berita;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // =========================================================
        // PAKAI QUERY LANGSUNG - TANPA CACHE DULU
        // =========================================================
        
        // Pengaturan Website
        $pengaturan = PengaturanWebsite::first() ?? (object) [
            'judul_hero' => 'Mengelola Tanah, Memajukan Negeri',
            'subjudul_hero' => 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.',
            'tombol_text' => 'Selengkapnya',
            'tombol_link' => '/aset',
            'warna_utama' => '#0B2A4A',
            'warna_sekunder' => '#1D4ED8',
        ];

        // Menu Navigasi
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();

        // Aset Terbaru
        $asets = AsetTanah::latest()->take(3)->get();

        // Berita Terbaru
        $berita = Berita::where('status', 'Dipublikasikan')->latest()->take(3)->get();

        // Filter Menu
        $mainMenus = $menuNavigasi->filter(function($menu) {
            return !in_array($menu->nama, ['FAQ', 'Karier', 'Kontak']);
        });

        $otherMenus = $menuNavigasi->filter(function($menu) {
            return in_array($menu->nama, ['FAQ', 'Karier', 'Kontak']);
        });

        return view('frontend.home', compact('asets', 'berita', 'menuNavigasi', 'pengaturan', 'mainMenus', 'otherMenus'));
    }
}