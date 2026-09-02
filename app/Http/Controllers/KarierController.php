<?php

namespace App\Http\Controllers;

use App\Models\Karier;
use App\Models\Lamaran;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;

class KarierController extends Controller
{
    public function index()
    {
        $kariers = Karier::all();
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.karier', compact('kariers', 'menuNavigasi', 'pengaturan'));
    }

    public function lamar($id)
    {
        $karier = Karier::findOrFail($id);
        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        return view('frontend.lamar', compact('karier', 'menuNavigasi', 'pengaturan'));
    }

    public function storeLamaran(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:255',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'pesan' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['karier_id'] = $id;
        $data['status'] = 'Baru';
        $data['is_read'] = false;

        if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
            $file = $request->file('cv');
            $filename = 'cv_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $data['cv'] = $file->storeAs('lamaran', $filename, 'public');
        }

        Lamaran::create($data);

        return redirect()->route('karier')->with('success', 'Lamaran berhasil dikirim!');
    }
}