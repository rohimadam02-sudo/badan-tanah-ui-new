<?php

namespace App\Http\Controllers;

use App\Models\AsetTanah;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    public function index()
    {
        $asets = AsetTanah::all();
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.assets', compact('asets', 'menuNavigasi', 'pengaturan'));
    }

    /**
     * Display the specified asset detail.
     */
    public function show($id)
    {
        // Cari aset berdasarkan ID
        $aset = AsetTanah::find($id);

        // Jika tidak ditemukan, tampilkan 404
        if (!$aset) {
            abort(404, 'Aset tidak ditemukan');
        }

        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.aset_detail', compact('aset', 'menuNavigasi', 'pengaturan'));
    }

    /**
     * API Filter for assets (AJAX)
     */
    public function filter(Request $request)
    {
        $query = AsetTanah::query();

        if ($request->provinsi) {
            $query->where('provinsi', $request->provinsi);
        }
        if ($request->luas_min) {
            $query->where('luas_hektar', '>=', $request->luas_min);
        }
        if ($request->luas_max) {
            $query->where('luas_hektar', '<=', $request->luas_max);
        }
        if ($request->peruntukan) {
            $query->where('peruntukan', $request->peruntukan);
        }
        if ($request->skema) {
            $query->where('skema', $request->skema);
        }

        return response()->json($query->get());
    }
}