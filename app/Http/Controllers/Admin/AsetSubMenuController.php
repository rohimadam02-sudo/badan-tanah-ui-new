<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetTanah;
use Illuminate\Http\Request;

class AsetSubMenuController extends Controller
{
    public function peta()
    {
        $asets = AsetTanah::all();
        return view('admin.aset_peta', compact('asets'));
    }

    public function profil()
    {
        return view('admin.aset_profil');
    }

    public function pengelolaan()
    {
        return view('admin.aset_pengelolaan');
    }

    public function pengembangan()
    {
        return view('admin.aset_pengembangan');
    }

    public function wilayah()
    {
        $asets = AsetTanah::all();
        return view('admin.aset_wilayah', compact('asets'));
    }

    public function status()
    {
        $asets = AsetTanah::all();
        return view('admin.aset_status', compact('asets'));
    }

    public function dokumen()
    {
        return view('admin.aset_dokumen');
    }

    public function statistik()
    {
        return view('admin.aset_statistik');
    }
}