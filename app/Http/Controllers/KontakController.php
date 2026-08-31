<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.kontak', compact('menuNavigasi', 'pengaturan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'telepon' => 'required',
            'pesan' => 'required',
        ]);

        Kontak::create($request->all());

        return redirect()->route('kontak')->with('success', 'Pesan berhasil dikirim!');
    }
}