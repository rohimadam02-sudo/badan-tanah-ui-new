<?php

/* =========================================================
    NAMESPACE & IMPORT
========================================================= */
namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use App\Helpers\TranslationHelper;
use Illuminate\Http\Request;

/* =========================================================
    CONTROLLER: FAQ (FRONTEND)
========================================================= */
class FaqController extends Controller
{
    /* =========================================================
        HALAMAN FAQ
    ========================================================= */
    public function index(Request $request)
    {
        $kategori = $request->input('kategori', 'Semua');
        
        $faqs = Faq::kategori($kategori)->get();
        $categories = Faq::getCategories();
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();
        $isEnglish = TranslationHelper::isEnglish();

        return view('frontend.faq', compact('faqs', 'categories', 'kategori', 'menuNavigasi', 'pengaturan', 'isEnglish'));
    }
}