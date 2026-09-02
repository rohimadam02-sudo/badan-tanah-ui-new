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
        $pengaturan = PengaturanWebsite::first() ?? (object) [
            'judul_hero' => 'Mengelola Tanah, Memajukan Negeri',
            'subjudul_hero' => 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.',
            'tombol_text' => 'Selengkapnya',
            'tombol_link' => '/aset',
            'warna_utama' => '#0B2A4A',
            'warna_sekunder' => '#1D4ED8',
        ];

        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();

        $asets = AsetTanah::latest()->take(3)->get();
        $berita = Berita::where('status', 'Dipublikasikan')->latest()->take(3)->get();

        // Get current locale
        $locale = session('locale', 'id');
        $isEnglish = $locale === 'en';

        // Translation helper function
        $t = function($data, $field) use ($isEnglish) {
            if (is_object($data) && property_exists($data, $field . '_en')) {
                $enValue = $data->{$field . '_en'};
                if ($isEnglish && !empty($enValue)) {
                    return $enValue;
                }
                return $data->$field ?? '';
            }
            return $data->$field ?? '';
        };

        // Pass translation helper to view
        $translate = $t;

        $mainMenus = $menuNavigasi->filter(function($menu) {
            return !in_array($menu->nama, ['FAQ', 'Karier', 'Kontak']);
        });

        $otherMenus = $menuNavigasi->filter(function($menu) {
            return in_array($menu->nama, ['FAQ', 'Karier', 'Kontak']);
        });

        return view('frontend.home', compact(
            'asets', 'berita', 'menuNavigasi', 'pengaturan',
            'mainMenus', 'otherMenus', 'translate', 'isEnglish'
        ));
    }
}