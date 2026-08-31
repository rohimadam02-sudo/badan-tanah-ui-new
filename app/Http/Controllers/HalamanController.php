<?php

namespace App\Http\Controllers;

use App\Models\Halaman;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HalamanController extends Controller
{
    /**
     * Frontend - Tentang Badan Bank Tanah
     */
    public function index()
    {
        $halaman = Halaman::where('judul', 'like', '%Tentang%')
            ->where('is_active', true)
            ->first();

        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        // Jika halaman tidak aktif atau tidak ditemukan, tampilkan 404
        if (! $halaman) {
            abort(404, 'Halaman tidak ditemukan atau tidak aktif.');
        }

        return view(
            'frontend.about',
            compact('halaman', 'menuNavigasi', 'pengaturan')
        );
    }

    /**
     * Frontend - Pemanfaatan & Kerjasama Usaha
     */
    public function partnership()
    {
        $halaman = Halaman::where('judul', 'like', '%Pemanfaatan%')
            ->where('is_active', true)
            ->first();

        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        // Jika halaman tidak ditemukan, buat default
        if (! $halaman) {
            $halaman = Halaman::create([
                'judul' => 'Pemanfaatan & Kerjasama Usaha',
                'isi' => 'Badan Bank Tanah membuka peluang kerjasama untuk investasi, reforma agraria, dan kemitraan strategis. Kami menyediakan skema pemanfaatan yang fleksibel dan transparan.',
                'is_active' => true,
                'slug' => 'pemanfaatan-dan-kerjasama-usaha',
                'skema_pemanfaatan' => [
                    ['icon' => 'fa-city', 'title' => 'Pemanfaatan untuk Kegiatan Usaha', 'description' => 'Pemanfaatan aset tanah untuk mendukung kegiatan usaha dan pengembangan kawasan sesuai ketentuan yang berlaku.'],
                    ['icon' => 'fa-handshake-angle', 'title' => 'Kerja Sama Pemanfaatan Aset', 'description' => 'Bentuk kerja sama antara Badan Bank Tanah dengan mitra untuk mengoptimalkan pemanfaatan aset tanah.'],
                    ['icon' => 'fa-chart-line', 'title' => 'Kemitraan Investasi', 'description' => 'Peluang kerja sama dengan mitra dalam pengembangan aset untuk kegiatan yang produktif dan berkelanjutan.'],
                ],
                'bentuk_kerjasama' => [
                    ['number' => '01', 'title' => 'Kerja Sama Pengembangan', 'description' => 'Kerja sama dalam pengembangan aset tanah menjadi kawasan atau kegiatan produktif.'],
                    ['number' => '02', 'title' => 'Kerja Sama Operasional', 'description' => 'Kerja sama untuk mendukung pengelolaan dan operasional pemanfaatan aset.'],
                    ['number' => '03', 'title' => 'Kemitraan Strategis', 'description' => 'Kemitraan dengan pihak yang memiliki kompetensi, sumber daya, atau investasi yang relevan.'],
                ],
                'prosedur_tahapan' => [
                    ['number' => '01', 'icon' => 'fa-map-location-dot', 'title' => 'Temukan Aset', 'description' => 'Cari dan lihat informasi aset persediaan tanah yang sesuai dengan kebutuhan.'],
                    ['number' => '02', 'icon' => 'fa-book-open', 'title' => 'Pelajari Skema', 'description' => 'Pahami pilihan pemanfaatan dan bentuk kerja sama yang tersedia.'],
                    ['number' => '03', 'icon' => 'fa-file-circle-check', 'title' => 'Siapkan Persyaratan', 'description' => 'Pelajari persyaratan dan dokumen yang diperlukan untuk proses selanjutnya.'],
                    ['number' => '04', 'icon' => 'fa-headset', 'title' => 'Hubungi Badan Bank Tanah', 'description' => 'Sampaikan kebutuhan dan lanjutkan komunikasi melalui kanal kontak yang tersedia.'],
                ],
                'persyaratan' => [
                    'Identitas atau profil calon mitra.',
                    'Penjelasan tujuan pemanfaatan aset.',
                    'Rencana kegiatan atau usaha.',
                    'Informasi kebutuhan lokasi dan luas tanah.',
                    'Dokumen pendukung sesuai jenis kerja sama.',
                ],
                'dokumen_pendukung' => [
                    'Profil calon mitra atau badan usaha.',
                    'Proposal pemanfaatan atau rencana kegiatan.',
                    'Dokumen legalitas yang relevan.',
                    'Dokumen teknis pendukung.',
                    'Dokumen lain sesuai skema kerja sama.',
                ],
                'faq_pemanfaatan' => [
                    ['question' => 'Bagaimana cara melihat aset yang tersedia?', 'answer' => 'Pengunjung dapat membuka halaman Aset Persediaan Tanah untuk melihat daftar aset dan informasi lokasi, luas, peruntukan, skema, serta status aset.'],
                    ['question' => 'Bagaimana mengetahui skema yang sesuai?', 'answer' => 'Pelajari informasi skema pemanfaatan dan bentuk kerja sama pada halaman ini, kemudian sesuaikan dengan kebutuhan pemanfaatan aset yang dipilih.'],
                    ['question' => 'Apa saja dokumen yang diperlukan?', 'answer' => 'Persyaratan dan dokumen dapat berbeda berdasarkan kebutuhan dan bentuk kerja sama. Informasi pada halaman ini merupakan contoh data dummy dan perlu disesuaikan dengan ketentuan resmi.'],
                    ['question' => 'Bagaimana cara melanjutkan proses?', 'answer' => 'Setelah memahami aset dan skema yang dibutuhkan, calon mitra dapat menghubungi Badan Bank Tanah melalui kanal kontak yang tersedia untuk memperoleh informasi lebih lanjut.'],
                ],
            ]);
        }

        return view(
            'frontend.partnership',
            compact('halaman', 'menuNavigasi', 'pengaturan')
        );
    }

    /**
     * Frontend - Publikasi Badan Bank Tanah
     */
    public function publikasi()
    {
        $halaman = Halaman::where('judul', 'like', '%Publikasi%')
            ->where('is_active', true)
            ->first();

        $menuNavigasi = MenuNavigasi::where('status', 'Aktif')->get();
        $pengaturan = PengaturanWebsite::first();

        if (! $halaman) {
            abort(404, 'Halaman tidak ditemukan atau tidak aktif.');
        }

        return view(
            'frontend.publikasi',
            compact('halaman', 'menuNavigasi', 'pengaturan')
        );
    }

    /**
     * Admin - Edit Tentang
     */
    public function editTentang()
    {
        $halaman = Halaman::findOrFail(1);

        return view(
            'admin.halaman_edit_tentang',
            compact('halaman')
        );
    }

    /**
     * Admin - Update Tentang
     */
    public function updateTentang(Request $request)
    {
        $halaman = Halaman::findOrFail(1);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'struktur_organisasi' => 'nullable|string',
            'dasar_hukum' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'struktur_organisasi' => $request->struktur_organisasi,
            'dasar_hukum' => $request->dasar_hukum,
            'is_active' => $request->has('is_active'),
        ];

        // Upload Gambar Hero
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            if ($halaman->gambar) {
                Storage::disk('public')->delete($halaman->gambar);
            }
            $file = $request->file('gambar');
            $filename = 'hero_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $data['gambar'] = $file->storeAs('halaman', $filename, 'public');
        }

        // Upload Foto Tambahan
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            if ($halaman->foto) {
                Storage::disk('public')->delete($halaman->foto);
            }
            $file = $request->file('foto');
            $filename = 'foto_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $data['foto'] = $file->storeAs('halaman', $filename, 'public');
        }

        // Update slug jika judul berubah
        if ($halaman->judul != $request->judul) {
            $data['slug'] = Str::slug($request->judul);
        }

        $halaman->update($data);

        // Log aktivitas
        activity()
            ->performedOn($halaman)
            ->causedBy(auth()->user())
            ->event('updated')
            ->log('memperbarui halaman Tentang');

        return redirect()
            ->route('admin.halaman.edit.tentang')
            ->with('success', 'Halaman Tentang berhasil diperbarui!');
    }

    /**
     * Admin - Edit Pemanfaatan & Kerjasama
     */
    public function editPartnership()
    {
        $halaman = Halaman::findOrFail(2);

        return view(
            'admin.halaman_edit_partnership',
            compact('halaman')
        );
    }

    /**
     * Admin - Update Pemanfaatan & Kerjasama
     */
    public function updatePartnership(Request $request)
    {
        $halaman = Halaman::findOrFail(2);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
            'skema_pemanfaatan' => 'nullable|array',
            'skema_pemanfaatan.*.icon' => 'nullable|string',
            'skema_pemanfaatan.*.title' => 'nullable|string',
            'skema_pemanfaatan.*.description' => 'nullable|string',
            'bentuk_kerjasama' => 'nullable|array',
            'bentuk_kerjasama.*.number' => 'nullable|string',
            'bentuk_kerjasama.*.title' => 'nullable|string',
            'bentuk_kerjasama.*.description' => 'nullable|string',
            'prosedur_tahapan' => 'nullable|array',
            'prosedur_tahapan.*.number' => 'nullable|string',
            'prosedur_tahapan.*.icon' => 'nullable|string',
            'prosedur_tahapan.*.title' => 'nullable|string',
            'prosedur_tahapan.*.description' => 'nullable|string',
            'persyaratan' => 'nullable|array',
            'persyaratan.*' => 'nullable|string',
            'dokumen_pendukung' => 'nullable|array',
            'dokumen_pendukung.*' => 'nullable|string',
            'faq_pemanfaatan' => 'nullable|array',
            'faq_pemanfaatan.*.question' => 'nullable|string',
            'faq_pemanfaatan.*.answer' => 'nullable|string',
        ]);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'is_active' => $request->has('is_active'),
            'skema_pemanfaatan' => $request->skema_pemanfaatan ?? [],
            'bentuk_kerjasama' => $request->bentuk_kerjasama ?? [],
            'prosedur_tahapan' => $request->prosedur_tahapan ?? [],
            'persyaratan' => $request->persyaratan ?? [],
            'dokumen_pendukung' => $request->dokumen_pendukung ?? [],
            'faq_pemanfaatan' => $request->faq_pemanfaatan ?? [],
        ];

        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            if ($halaman->gambar) {
                Storage::disk('public')->delete($halaman->gambar);
            }
            $file = $request->file('gambar');
            $filename = 'hero_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $data['gambar'] = $file->storeAs('halaman', $filename, 'public');
        }

        if ($halaman->judul != $request->judul) {
            $data['slug'] = Str::slug($request->judul);
        }

        $halaman->update($data);

        // Log aktivitas
        activity()
            ->performedOn($halaman)
            ->causedBy(auth()->user())
            ->event('updated')
            ->log('memperbarui halaman Pemanfaatan & Kerjasama');

        return redirect()
            ->route('admin.halaman.edit.partnership')
            ->with('success', 'Halaman Pemanfaatan & Kerjasama berhasil diperbarui!');
    }
}