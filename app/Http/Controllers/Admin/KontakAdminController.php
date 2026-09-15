<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakAdminController extends Controller
{
    public function index()
    {
        // Urutkan pesan dari yang terbaru
        $kontaks = Kontak::latest()->get();
        return view('admin.kontak_index', compact('kontaks'));
    }

    public function show($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->is_read = 1; // Tandai sebagai dibaca
        $kontak->save();

        return view('admin.kontak_show', compact('kontak'));
    }

    public function destroy($id)
    {
        Kontak::findOrFail($id)->delete();
        return redirect()->route('admin.kontak.index')->with('success', 'Pesan berhasil dihapus!');
    }
}