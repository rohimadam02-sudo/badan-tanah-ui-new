<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenKerjasama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenKerjasamaController extends Controller
{
    public function index()
    {
        $dokumen = DokumenKerjasama::orderBy('urutan')->get();
        return view('admin.dokumen_kerjasama_index', compact('dokumen'));
    }

    public function create()
    {
        return view('admin.dokumen_kerjasama_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:10240',
            'kategori' => 'required|string',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('dokumen_kerjasama', $fileName, 'public');

        DokumenKerjasama::create([
            'judul' => $request->judul,
            'file_path' => $filePath,
            'ukuran' => $this->formatFileSize($file->getSize()),
            'kategori' => $request->kategori,
            'is_active' => $request->has('is_active'),
            'urutan' => DokumenKerjasama::max('urutan') + 1,
        ]);

        return redirect()->route('admin.dokumen-kerjasama.index')
            ->with('success', 'Dokumen berhasil diupload!');
    }

    public function edit($id)
    {
        $dokumen = DokumenKerjasama::findOrFail($id);
        return view('admin.dokumen_kerjasama_edit', compact('dokumen'));
    }

    public function update(Request $request, $id)
    {
        $dokumen = DokumenKerjasama::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('file')) {
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dokumen_kerjasama', $fileName, 'public');
            $data['file_path'] = $filePath;
            $data['ukuran'] = $this->formatFileSize($file->getSize());
        }

        $dokumen->update($data);

        return redirect()->route('admin.dokumen-kerjasama.index')
            ->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dokumen = DokumenKerjasama::findOrFail($id);
        if ($dokumen->file_path) {
            Storage::disk('public')->delete($dokumen->file_path);
        }
        $dokumen->delete();

        return redirect()->route('admin.dokumen-kerjasama.index')
            ->with('success', 'Dokumen berhasil dihapus!');
    }

    public function download($id)
    {
        $dokumen = DokumenKerjasama::findOrFail($id);
        return response()->download(storage_path('app/public/' . $dokumen->file_path));
    }

    private function formatFileSize($bytes)
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}