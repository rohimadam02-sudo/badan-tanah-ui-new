<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengaturanWebsite;

class IntegrasiController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanWebsite::first();
        return view('admin.integrasi', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'google_analytics' => 'nullable|string',
            'kimi_api_key' => 'nullable|string',
            'qr_enabled' => 'nullable|boolean',
        ]);

        $pengaturan = PengaturanWebsite::first();
        if (!$pengaturan) {
            $pengaturan = new PengaturanWebsite();
        }

        $pengaturan->google_analytics = $request->google_analytics;
        $pengaturan->kimi_api_key = $request->kimi_api_key;
        $pengaturan->qr_enabled = $request->has('qr_enabled');
        $pengaturan->save();

        return redirect()->route('admin.integrasi')->with('success', 'Pengaturan integrasi berhasil diperbarui!');
    }
}