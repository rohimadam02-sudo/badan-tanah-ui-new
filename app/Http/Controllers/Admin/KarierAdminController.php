<?php

/* =========================================================
    NAMESPACE & IMPORT
========================================================= */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karier;
use Illuminate\Http\Request;

/* =========================================================
    CONTROLLER: KARIER ADMIN
========================================================= */
class KarierAdminController extends Controller
{
    /* =========================================================
        DAFTAR LOWONGAN
    ========================================================= */
    public function index()
    {
        $kariers = Karier::all();
        return view('admin.karier_index', compact('kariers'));
    }

    /* =========================================================
        FORM TAMBAH LOWONGAN
    ========================================================= */
    public function create()
    {
        return view('admin.karier_create');
    }

    /* =========================================================
        SIMPAN LOWONGAN BARU
    ========================================================= */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kualifikasi' => 'required',
            'lokasi' => 'required',
            'status' => 'required',
        ]);

        Karier::create($request->all());

        return redirect()->route('admin.karier.index')->with('success', 'Lowongan berhasil ditambahkan!');
    }

    /* =========================================================
        FORM EDIT LOWONGAN
    ========================================================= */
    public function edit($id)
    {
        $karier = Karier::findOrFail($id);
        return view('admin.karier_edit', compact('karier'));
    }

    /* =========================================================
        UPDATE LOWONGAN
    ========================================================= */
    public function update(Request $request, $id)
    {
        $karier = Karier::findOrFail($id);
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kualifikasi' => 'required',
            'lokasi' => 'required',
            'status' => 'required',
        ]);

        $karier->update($request->all());

        return redirect()->route('admin.karier.index')->with('success', 'Lowongan berhasil diubah!');
    }

    /* =========================================================
        HAPUS LOWONGAN
    ========================================================= */
    public function destroy($id)
    {
        Karier::findOrFail($id)->delete();
        return redirect()->route('admin.karier.index')->with('success', 'Lowongan berhasil dihapus!');
    }
}