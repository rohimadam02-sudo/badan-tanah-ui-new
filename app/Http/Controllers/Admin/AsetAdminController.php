<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetTanah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class AsetAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asets = AsetTanah::all();
        $totalAset = AsetTanah::count();
        return view('admin.aset_index', compact('asets', 'totalAset'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.aset_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'luas_hektar' => 'required|numeric|min:0',
            'peruntukan' => 'nullable|string|max:255',
            'skema' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'dokumen' => 'nullable|array',
            'dokumen.*' => 'nullable|string',
        ]);

        $data = $request->except(['gambar', 'dokumen']);

        // Upload Gambar
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $file = $request->file('gambar');
            $filename = 'aset_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $data['gambar'] = $file->storeAs('asets', $filename, 'public');
        }

        // Dokumen - filter array kosong
        if ($request->has('dokumen')) {
            $data['dokumen'] = array_filter($request->dokumen, function($item) {
                return !empty(trim($item));
            });
            $data['dokumen'] = array_values($data['dokumen']); // reindex
        }

        $aset = AsetTanah::create($data);

        // Log aktivitas
        activity()
            ->performedOn($aset)
            ->causedBy(auth()->user())
            ->event('created')
            ->log('menambahkan aset "' . $aset->nama_lokasi . '"');

        return redirect()
            ->route('admin.aset.index')
            ->with('success', 'Aset berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $aset = AsetTanah::findOrFail($id);
        return view('admin.aset_edit', compact('aset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $aset = AsetTanah::findOrFail($id);

        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'luas_hektar' => 'required|numeric|min:0',
            'peruntukan' => 'nullable|string|max:255',
            'skema' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'dokumen' => 'nullable|array',
            'dokumen.*' => 'nullable|string',
        ]);

        $data = $request->except(['gambar', 'dokumen']);

        // Upload Gambar
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            if ($aset->gambar) {
                Storage::disk('public')->delete($aset->gambar);
            }
            $file = $request->file('gambar');
            $filename = 'aset_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $data['gambar'] = $file->storeAs('asets', $filename, 'public');
        }

        // Dokumen - filter array kosong
        if ($request->has('dokumen')) {
            $data['dokumen'] = array_filter($request->dokumen, function($item) {
                return !empty(trim($item));
            });
            $data['dokumen'] = array_values($data['dokumen']); // reindex
        } else {
            $data['dokumen'] = [];
        }

        $aset->update($data);

        // Log aktivitas
        activity()
            ->performedOn($aset)
            ->causedBy(auth()->user())
            ->event('updated')
            ->log('mengubah aset "' . $aset->nama_lokasi . '"');

        return redirect()
            ->route('admin.aset.index')
            ->with('success', 'Aset berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $aset = AsetTanah::findOrFail($id);
        $nama = $aset->nama_lokasi;

        if ($aset->gambar) {
            Storage::disk('public')->delete($aset->gambar);
        }

        $aset->delete();

        // Log aktivitas
        activity()
            ->performedOn($aset)
            ->causedBy(auth()->user())
            ->event('deleted')
            ->log('menghapus aset "' . $nama . '"');

        return redirect()
            ->route('admin.aset.index')
            ->with('success', 'Aset berhasil dihapus!');
    }

    /**
     * =========================================================
     * API / AJAX METHODS
     * =========================================================
     */

    /**
     * Get all assets for map
     */
    public function getMapData()
    {
        $asets = AsetTanah::select('id', 'nama_lokasi', 'provinsi', 'kabupaten', 'lat', 'lng', 'status', 'luas_hektar')
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->get();

        return response()->json($asets);
    }

    /**
     * Export assets to CSV
     */
    public function export()
    {
        $asets = AsetTanah::all();

        $csv = "ID,Nama Lokasi,Provinsi,Kabupaten,Luas (Ha),Peruntukan,Skema,Status\n";
        foreach ($asets as $aset) {
            $csv .= "{$aset->id},{$aset->nama_lokasi},{$aset->provinsi},{$aset->kabupaten},{$aset->luas_hektar},{$aset->peruntukan},{$aset->skema},{$aset->status}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="aset_tanah_' . date('Y-m-d') . '.csv"');
    }

    /**
     * Bulk delete assets
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada aset yang dipilih.']);
        }

        $asets = AsetTanah::whereIn('id', $ids)->get();

        foreach ($asets as $aset) {
            if ($aset->gambar) {
                Storage::disk('public')->delete($aset->gambar);
            }
            $aset->delete();
        }

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' aset berhasil dihapus.'
        ]);
    }
}