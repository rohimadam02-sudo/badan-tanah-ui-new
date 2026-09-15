<?php

namespace App\Http\Controllers;

use App\Models\AsetTanah;
use App\Models\Berita; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik dari database
        $totalAset = AsetTanah::count();
        $totalLuas = AsetTanah::sum('luas_hektar');
        $totalBerita = Berita::count();
        $totalPengunjung = 124530; // Placeholder

        // Data aset terbaru untuk tabel
        $asets = AsetTanah::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalAset', 'totalLuas', 'totalBerita', 'totalPengunjung', 'asets'));
    }
}