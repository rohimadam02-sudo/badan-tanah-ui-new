<?php

namespace App\Http\Controllers;

use App\Models\Karier;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class KarierController extends Controller
{
    public function index()
    {
        $kariers = Karier::all();
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.karier', compact('kariers', 'menuNavigasi', 'pengaturan'));
    }
}