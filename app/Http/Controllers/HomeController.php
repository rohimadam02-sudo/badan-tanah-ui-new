<?php

namespace App\Http\Controllers;

use App\Models\AsetTanah;
use App\Models\Berita;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;
use App\Helpers\CacheHelper;

class HomeController extends Controller
{
    public function index()
    {
        // Cache data yang jarang berubah
        $pengaturan = CacheHelper::remember('pengaturan_website', 1440, function () {
            return PengaturanWebsite::first() ?? (object) [
                'judul_hero' => 'Mengelola Tanah, Memajukan Negeri',
                'subjudul_hero' => 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.',
                'tombol_text' => 'Selengkapnya',
                'tombol_link' => '/aset',
                'warna_utama' => '#0B2A4A',
                'warna_sekunder' => '#1D4ED8',
            ];
        });

        $menuNavigasi = CacheHelper::remember('menu_navigasi_active', 1440, function () {
            return MenuNavigasi::where('status', 'Aktif')->get();
        });

        // Data yang lebih dinamis dengan cache lebih pendek
        $asets = CacheHelper::remember('home_asets', 60, function () {
            return AsetTanah::latest()->take(3)->get();
        });

        $berita = CacheHelper::remember('home_berita', 60, function () {
            return Berita::where('status', 'Dipublikasikan')->latest()->take(3)->get();
        });

        $mainMenus = $menuNavigasi->filter(function($menu) {
            return !in_array($menu->nama, ['FAQ', 'Karier', 'Kontak']);
        });

        $otherMenus = $menuNavigasi->filter(function($menu) {
            return in_array($menu->nama, ['FAQ', 'Karier', 'Kontak']);
        });

        return view('frontend.home', compact('asets', 'berita', 'menuNavigasi', 'pengaturan', 'mainMenus', 'otherMenus'));
    }
}