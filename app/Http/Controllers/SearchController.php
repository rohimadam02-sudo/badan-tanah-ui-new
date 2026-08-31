<?php

namespace App\Http\Controllers;

use App\Models\AsetTanah;
use App\Models\Berita;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('q');

        if ($keyword) {
            $asets = AsetTanah::where('nama_lokasi', 'like', "%{$keyword}%")
                             ->orWhere('provinsi', 'like', "%{$keyword}%")
                             ->get();
            $berita = Berita::where('judul', 'like', "%{$keyword}%")
                            ->orWhere('konten', 'like', "%{$keyword}%")
                            ->get();
        } else {
            $asets = [];
            $berita = [];
        }

        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.search', compact('keyword', 'asets', 'berita', 'menuNavigasi', 'pengaturan'));
    }
}