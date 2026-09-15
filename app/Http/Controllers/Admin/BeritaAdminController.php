<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Activitylog\Models\Activity;

class BeritaAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::latest()->get();
        return view('admin.berita_index', compact('berita'));
    }

    /**
     * Halaman khusus Siaran Pers
     */
    public function siaranPers()
    {
        $berita = Berita::where('kategori', 'Siaran Pers')->latest()->get();
        return view('admin.berita_index', compact('berita'));
    }

    /**
     * Halaman khusus Pengumuman
     */
    public function pengumuman()
    {
        $berita = Berita::where('kategori', 'Pengumuman')->latest()->get();
        return view('admin.berita_index', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = auth()->user()->role;
        if ($role == 'publisher') {
            abort(403, 'Publisher tidak memiliki akses untuk membuat konten.');
        }
        return view('admin.berita_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = auth()->user()->role;

        if ($role == 'publisher') {
            abort(403, 'Publisher tidak memiliki akses untuk membuat konten.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string',
        ], [
            'judul.required' => 'Judul tidak boleh kosong!',
            'konten.required' => 'Konten tidak boleh kosong!',
            'kategori.required' => 'Kategori tidak boleh kosong!',
        ]);

        // Generate slug
        $slug = Str::slug($request->judul);
        $originalSlug = $slug;
        $count = 1;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Ringkasan
        $ringkasan = $request->ringkasan ?: Str::limit(strip_tags($request->konten), 150, '...');

        // Upload gambar
        $gambarPath = null;
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $file = $request->file('gambar');
            $filename = 'berita_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $gambarPath = $file->storeAs('berita', $filename, 'public');
        }

        // Tentukan status berdasarkan role dan input
        $status = 'Draft';
        $statusApproval = 'Draft';
        $tanggalPublikasi = null;

        // Ambil status dari request (tombol yang diklik)
        $requestStatus = $request->input('status', 'Draft');

        if (in_array($role, ['super_admin', 'admin'])) {
            if ($requestStatus == 'Terbit') {
                $status = 'Dipublikasikan';
                $statusApproval = 'Dipublikasikan';
                $tanggalPublikasi = now();
            } elseif ($requestStatus == 'Menunggu Approval') {
                $status = 'Menunggu Approval';
                $statusApproval = 'Menunggu Approval';
            } else {
                $status = 'Draft';
                $statusApproval = 'Draft';
            }
        } elseif ($role == 'editor') {
            if ($requestStatus == 'Menunggu Approval') {
                $status = 'Menunggu Approval';
                $statusApproval = 'Menunggu Approval';
            } else {
                $status = 'Draft';
                $statusApproval = 'Draft';
            }
        }

        $berita = Berita::create([
            'judul' => $request->judul,
            'slug' => $slug,
            'ringkasan' => $ringkasan,
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'penulis' => auth()->user()->name,
            'views' => 0,
            'status' => $status,
            'status_approval' => $statusApproval,
            'gambar' => $gambarPath,
            'tanggal_publikasi' => $tanggalPublikasi,
        ]);

        // Tambahkan riwayat awal
        $berita->addApprovalHistory('created', 'Berita dibuat');

        $message = $status == 'Dipublikasikan' ? 'Berita berhasil diterbitkan!' : 'Berita berhasil disimpan sebagai Draft!';

        return redirect()->route('admin.berita.index')->with('success', $message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);

        $role = auth()->user()->role;
        $canEdit = false;

        if (in_array($role, ['super_admin', 'admin'])) {
            $canEdit = true;
        } elseif ($role == 'publisher') {
            $canEdit = true;
        } elseif ($role == 'editor' && $berita->penulis == auth()->user()->name) {
            $canEdit = true;
        }

        if (!$canEdit) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit berita ini.');
        }

        return view('admin.berita_edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $role = auth()->user()->role;
        $canEdit = false;

        if (in_array($role, ['super_admin', 'admin'])) {
            $canEdit = true;
        } elseif ($role == 'publisher') {
            $canEdit = true;
        } elseif ($role == 'editor' && $berita->penulis == auth()->user()->name) {
            $canEdit = true;
        }

        if (!$canEdit) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit berita ini.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|string',
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'kategori' => $request->kategori,
            'ringkasan' => $request->ringkasan ?: Str::limit(strip_tags($request->konten), 150, '...'),
        ];

        // Upload gambar
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $file = $request->file('gambar');
            $filename = 'berita_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $data['gambar'] = $file->storeAs('berita', $filename, 'public');
        }

        // Update slug jika judul berubah
        if ($berita->judul != $request->judul) {
            $slug = Str::slug($request->judul);
            $originalSlug = $slug;
            $count = 1;
            while (Berita::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $data['slug'] = $slug;
        }

        // Ambil status dari request (tombol yang diklik)
        $requestStatus = $request->input('status', 'Draft');

        // Proses berdasarkan role
        if ($role == 'editor') {
            if ($requestStatus == 'Menunggu Approval') {
                $data['status'] = 'Menunggu Approval';
                $data['status_approval'] = 'Menunggu Approval';
                $berita->addApprovalHistory('submit', 'Berita disubmit untuk approval');
            } else {
                $data['status'] = 'Draft';
                $data['status_approval'] = 'Draft';
            }
        } elseif ($role == 'publisher') {
            if ($requestStatus == 'Terbit') {
                $data['status'] = 'Dipublikasikan';
                $data['status_approval'] = 'Dipublikasikan';
                $data['tanggal_publikasi'] = now();
                $berita->addApprovalHistory('publish', 'Berita dipublikasikan oleh Publisher');
            } elseif ($requestStatus == 'Menunggu Approval') {
                $data['status'] = 'Menunggu Approval';
                $data['status_approval'] = 'Menunggu Approval';
            } else {
                $data['status'] = 'Draft';
                $data['status_approval'] = 'Draft';
            }
        } elseif (in_array($role, ['super_admin', 'admin'])) {
            if ($requestStatus == 'Terbit') {
                $data['status'] = 'Dipublikasikan';
                $data['status_approval'] = 'Dipublikasikan';
                $data['tanggal_publikasi'] = now();
                $berita->addApprovalHistory('publish', 'Berita dipublikasikan oleh Admin');
            } elseif ($requestStatus == 'Menunggu Approval') {
                $data['status'] = 'Menunggu Approval';
                $data['status_approval'] = 'Menunggu Approval';
                $berita->addApprovalHistory('submit', 'Berita disubmit untuk approval oleh Admin');
            } else {
                $data['status'] = 'Draft';
                $data['status_approval'] = 'Draft';
            }
        }

        $berita->update($data);

        if ($requestStatus != 'Draft' && $requestStatus != 'Menunggu Approval' && $requestStatus != 'Terbit') {
            $berita->addApprovalHistory('updated', 'Konten berita diperbarui');
        }

        $message = $data['status'] == 'Dipublikasikan' ? 'Berita berhasil diterbitkan!' : 'Berita berhasil diperbarui!';

        return redirect()->route('admin.berita.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus.');
        }

        $judul = $berita->judul;

        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        activity()
            ->performedOn($berita)
            ->causedBy(auth()->user())
            ->event('deleted')
            ->log('menghapus berita "' . $judul . '"');

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }

    // =========================================================
    // APPROVAL WORKFLOW METHODS
    // =========================================================

    /**
     * Submit berita untuk approval (Editor → Publisher)
     */
    public function submit($id)
    {
        $berita = Berita::findOrFail($id);

        if (auth()->user()->role == 'publisher') {
            return redirect()->route('admin.berita.index')->with('error', 'Publisher tidak dapat melakukan submit.');
        }

        if ($berita->status == 'Dipublikasikan') {
            return redirect()->route('admin.berita.index')->with('error', 'Berita sudah dipublikasikan, tidak bisa disubmit.');
        }

        if ($berita->status_approval == 'Menunggu Approval') {
            return redirect()->route('admin.berita.index')->with('error', 'Berita sudah dalam status Menunggu Approval.');
        }

        $berita->status = 'Menunggu Approval';
        $berita->status_approval = 'Menunggu Approval';
        $berita->addApprovalHistory('submit', 'Berita disubmit untuk approval');
        $berita->save();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil disubmit! Menunggu approval Publisher.');
    }

    /**
     * Approve berita (Publisher → Approved)
     */
    public function approve($id)
    {
        $berita = Berita::findOrFail($id);

        if (!in_array(auth()->user()->role, ['publisher', 'admin', 'super_admin'])) {
            return redirect()->route('admin.berita.index')->with('error', 'Anda tidak memiliki akses untuk approve.');
        }

        if ($berita->status == 'Dipublikasikan') {
            return redirect()->route('admin.berita.index')->with('error', 'Berita sudah dipublikasikan.');
        }

        if ($berita->status_approval == 'Disetujui') {
            return redirect()->route('admin.berita.index')->with('error', 'Berita sudah disetujui sebelumnya.');
        }

        $berita->status_approval = 'Disetujui';
        $berita->addApprovalHistory('approve', 'Berita disetujui');
        $berita->save();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil disetujui! Siap untuk dipublikasikan.');
    }

    /**
     * Publish berita (Publisher/Admin → Published)
     */
    public function publish($id)
    {
        $berita = Berita::findOrFail($id);

        if (!in_array(auth()->user()->role, ['publisher', 'admin', 'super_admin'])) {
            return redirect()->route('admin.berita.index')->with('error', 'Anda tidak memiliki akses untuk publish.');
        }

        // Jika berita dalam status Arsip, publish ulang
        if ($berita->status == 'Arsip') {
            $berita->status = 'Dipublikasikan';
            $berita->status_approval = 'Dipublikasikan';
            $berita->tanggal_publikasi = now();
            $berita->addApprovalHistory('publish', 'Berita dipublikasikan kembali (restore dari arsip)');
            $berita->save();
            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dipublikasikan kembali!');
        }

        if ($berita->status == 'Dipublikasikan') {
            return redirect()->route('admin.berita.index')->with('error', 'Berita sudah dipublikasikan.');
        }

        if ($berita->status_approval != 'Disetujui' && !in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            return redirect()->route('admin.berita.index')->with('error', 'Berita harus disetujui terlebih dahulu sebelum dipublikasikan.');
        }

        $berita->status = 'Dipublikasikan';
        $berita->status_approval = 'Dipublikasikan';
        $berita->tanggal_publikasi = now();
        $berita->addApprovalHistory('publish', 'Berita dipublikasikan');
        $berita->save();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    /**
     * Unpublish / Arsipkan berita (Publisher/Admin → Archived)
     */
    public function unpublish($id)
    {
        $berita = Berita::findOrFail($id);

        if (!in_array(auth()->user()->role, ['publisher', 'admin', 'super_admin'])) {
            return redirect()->route('admin.berita.index')->with('error', 'Anda tidak memiliki akses untuk unpublish.');
        }

        if ($berita->status != 'Dipublikasikan') {
            return redirect()->route('admin.berita.index')->with('error', 'Berita belum dipublikasikan.');
        }

        $berita->status = 'Arsip';
        $berita->status_approval = 'Arsip';
        $berita->addApprovalHistory('unpublish', 'Berita diarsipkan');
        $berita->save();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diarsipkan!');
    }

    /**
     * Get pending count for notification badge
     */
    public function getPendingCount()
    {
        $count = Berita::where('status_approval', 'Menunggu Approval')->count();
        return response()->json(['count' => $count]);
    }

    // =========================================================
    // BULK DELETE
    // =========================================================

    /**
     * Bulk delete berita
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada berita yang dipilih.']);
        }

        // Cek permission
        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus.']);
        }

        // Ambil berita untuk logging
        $berita = Berita::whereIn('id', $ids)->get();
        $judulList = $berita->pluck('judul')->implode(', ');

        // Hapus gambar
        foreach ($berita as $item) {
            if ($item->gambar) {
                Storage::disk('public')->delete($item->gambar);
            }
        }

        $count = Berita::whereIn('id', $ids)->delete();

        // Log aktivitas
        activity()
            ->withProperties(['ids' => $ids, 'count' => $count])
            ->log('menghapus ' . $count . ' berita secara massal: ' . $judulList);

        return response()->json([
            'success' => true,
            'message' => $count . ' berita berhasil dihapus.'
        ]);
    }

    // =========================================================
    // QR CODE GENERATOR
    // =========================================================

    /**
     * Generate QR Code for a berita
     */
    public function generateQrCode($id)
    {
        $berita = Berita::findOrFail($id);
        
        // Generate URL untuk detail berita
        $url = route('publications.show', $berita->id);
        
        // Generate QR Code dalam bentuk SVG
        $qrCode = QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate($url);
        
        // Simpan ke database
        $berita->qr_code = $qrCode;
        $berita->save();
        
        return response()->json([
            'success' => true,
            'qr_code' => $qrCode,
        ]);
    }
}