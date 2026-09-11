<?php

/* =========================================================
    NAMESPACE & IMPORT
========================================================= */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetTanah;
use Illuminate\Http\Request;

/* =========================================================
    CONTROLLER: ASET SUB MENU
========================================================= */
class AsetSubMenuController extends Controller
{
    /* =========================================================
        HALAMAN PETA ASET
    ========================================================= */
    public function peta()
    {
        $asets = AsetTanah::all();
        return view('admin.aset_peta', compact('asets'));
    }

    /* =========================================================
        HALAMAN PROFIL ASET
    ========================================================= */
    public function profil()
    {
        return view('admin.aset_profil');
    }

    /* =========================================================
        HALAMAN PENGELOLAAN ASET
    ========================================================= */
    public function pengelolaan()
    {
        return view('admin.aset_pengelolaan');
    }

    /* =========================================================
        HALAMAN PENGEMBANGAN ASET
    ========================================================= */
    public function pengembangan()
    {
        return view('admin.aset_pengembangan');
    }

    /* =========================================================
        HALAMAN WILAYAH ASET
    ========================================================= */
    public function wilayah()
    {
        $asets = AsetTanah::all();
        return view('admin.aset_wilayah', compact('asets'));
    }

    /* =========================================================
        HALAMAN STATUS ASET
    ========================================================= */
    public function status()
    {
        $asets = AsetTanah::all();
        return view('admin.aset_status', compact('asets'));
    }

    /* =========================================================
        HALAMAN DOKUMEN ASET
    ========================================================= */
    public function dokumen()
    {
        return view('admin.aset_dokumen');
    }

    /* =========================================================
        HALAMAN STATISTIK ASET
    ========================================================= */
    public function statistik()
    {
        return view('admin.aset_statistik');
    }
}