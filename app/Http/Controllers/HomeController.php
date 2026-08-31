<?php

namespace App\Http\Controllers;

use App\Models\AsetTanah;
use App\Models\Berita;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $asets = AsetTanah::latest()->take(3)->get();
        $berita = Berita::where('status', 'Dipublikasikan')->latest()->take(3)->get();
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        // Pisahkan menu utama dan menu lainnya
        $mainMenus = $menuNavigasi->filter(function($menu) {
            return !in_array($menu->nama, ['FAQ', 'Karier', 'Kontak']);
        });

        $otherMenus = $menuNavigasi->filter(function($menu) {
            return in_array($menu->nama, ['FAQ', 'Karier', 'Kontak']);
        });

        if (!$pengaturan) {
            $pengaturan = (object) [
                'judul_hero' => 'Mengelola Tanah, Memajukan Negeri',
                'subjudul_hero' => 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.',
                'tombol_text' => 'Selengkapnya',
                'tombol_link' => '/aset',
                'warna_utama' => '#0B2A4A',
                'warna_sekunder' => '#1D4ED8',
            ];
        }

        return view('frontend.home', compact('asets', 'berita', 'menuNavigasi', 'pengaturan', 'mainMenus', 'otherMenus'));
    }
}