<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use App\Helpers\TranslationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KontakController extends Controller
{
    public function index()
    {
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();
        $isEnglish = TranslationHelper::isEnglish();

        return view('frontend.kontak', compact('menuNavigasi', 'pengaturan', 'isEnglish'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'telepon' => 'required',
            'pesan' => 'required',
        ]);

        $kontak = Kontak::create($request->all());

        // =========================================================
        // CLEAR NOTIFICATION CACHE
        // =========================================================
        // Clear cache untuk semua admin (biar notifikasi muncul)
        $adminUsers = \App\Models\User::whereIn('role', ['super_admin', 'admin'])->get();
        foreach ($adminUsers as $admin) {
            Cache::forget('notifications_' . $admin->id);
            Cache::forget('unread_count_' . $admin->id);
        }

        return redirect()->route('kontak')->with('success', 'Pesan berhasil dikirim!');
    }
}