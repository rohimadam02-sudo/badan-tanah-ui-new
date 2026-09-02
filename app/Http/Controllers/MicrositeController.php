<?php

namespace App\Http\Controllers;

use App\Models\Microsite;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class MicrositeController extends Controller
{
    public function index()
    {
        $microsites = Microsite::where('is_active', true)
            ->latest()
            ->get();
        
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.microsite_list', compact('microsites', 'menuNavigasi', 'pengaturan'));
    }

    public function show($slug)
    {
        $microsite = Microsite::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $microsite->increment('views');

        return view('frontend.microsite', compact('microsite'));
    }
}