<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.faq', compact('faqs', 'menuNavigasi', 'pengaturan'));
    }
}