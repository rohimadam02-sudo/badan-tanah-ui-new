<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karier;
use Illuminate\Http\Request;

class KarierAdminController extends Controller
{
    public function index()
    {
        $kariers = Karier::all();
        return view('admin.karier_index', compact('kariers'));
    }

    public function create()
    {
        return view('admin.karier_create');
    }

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

    public function edit($id)
    {
        $karier = Karier::findOrFail($id);
        return view('admin.karier_edit', compact('karier'));
    }

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

    public function destroy($id)
    {
        Karier::findOrFail($id)->delete();
        return redirect()->route('admin.karier.index')->with('success', 'Lowongan berhasil dihapus!');
    }
}