<?php

namespace Database\Seeders;

use App\Models\AsetTanah;
use App\Models\Berita;
use App\Models\Halaman;
use App\Models\MenuNavigasi;
use App\Models\PengaturanWebsite;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // =========================================================
        // PENGATURAN WEBSITE
        // =========================================================
        PengaturanWebsite::updateOrCreate(
            ['id' => 1],
            [
                'judul_hero' => 'Mengelola Tanah, Memajukan Negeri',
                'subjudul_hero' => 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.',
                'tombol_text' => 'Selengkapnya',
                'tombol_link' => '/aset',
                'warna_utama' => '#0B2A4A',
                'warna_sekunder' => '#1D4ED8',
                'nama_website' => 'Badan Bank Tanah',
                'deskripsi_website' => 'Badan Bank Tanah mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.',
            ]
        );

        // =========================================================
        // HALAMAN TENTANG (ID: 1)
        // =========================================================
        Halaman::updateOrCreate(
            ['id' => 1],
            [
                'judul' => 'Tentang Badan Bank Tanah',
                'isi' => 'Badan Bank Tanah adalah lembaga pemerintah yang mengelola aset tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.',
                'visi' => 'Menjadi lembaga pengelola tanah yang profesional, transparan, dan berkelanjutan untuk mewujudkan kedaulatan dan kemakmuran rakyat.',
                'misi' => "1. Mengelola aset tanah negara secara profesional dan akuntabel.\n2. Mewujudkan tata kelola tanah yang transparan dan berkeadilan.\n3. Mendukung program Reforma Agraria dan pembangunan nasional.\n4. Meningkatkan kesejahteraan masyarakat melalui pemanfaatan tanah yang produktif.",
                'struktur_organisasi' => "Struktur organisasi Badan Bank Tanah terdiri dari:\n1. Kepala Badan\n2. Sekretariat\n3. Deputi Bidang Perencanaan dan Pengembangan\n4. Deputi Bidang Pengelolaan Aset\n5. Deputi Bidang Pemanfaatan dan Kerjasama\n6. Deputi Bidang Hukum dan Hubungan Masyarakat",
                'dasar_hukum' => "1. Undang-Undang Nomor 11 Tahun 2020 tentang Cipta Kerja\n2. Peraturan Pemerintah Nomor 64 Tahun 2021 tentang Badan Bank Tanah\n3. Peraturan Presiden Nomor 62 Tahun 2021 tentang Tata Kelola Badan Bank Tanah",
                'gambar' => null,
                'foto' => null,
                'is_active' => true,
                'slug' => 'tentang-badan-bank-tanah',
                'meta_title' => 'Tentang Badan Bank Tanah',
                'meta_description' => 'Mengenal Badan Bank Tanah, visi dan misi, struktur organisasi, serta landasan hukum dalam pengelolaan tanah negara.',
            ]
        );

        // =========================================================
        // HALAMAN PEMANFAATAN (ID: 2)
        // =========================================================
        Halaman::updateOrCreate(
            ['id' => 2],
            [
                'judul' => 'Pemanfaatan & Kerjasama Usaha',
                'isi' => 'Badan Bank Tanah membuka peluang kerjasama untuk investasi, reforma agraria, dan kemitraan strategis. Kami menyediakan skema pemanfaatan yang fleksibel dan transparan.',
                'visi' => null,
                'misi' => null,
                'struktur_organisasi' => null,
                'dasar_hukum' => null,
                'gambar' => null,
                'foto' => null,
                'is_active' => true,
                'slug' => 'pemanfaatan-dan-kerjasama-usaha',
                'meta_title' => 'Pemanfaatan & Kerjasama Usaha',
                'meta_description' => 'Informasi mengenai skema pemanfaatan dan kerjasama usaha atas aset tanah Badan Bank Tanah.',
            ]
        );

        // =========================================================
        // HALAMAN PUBLIKASI (ID: 3)
        // =========================================================
        Halaman::updateOrCreate(
            ['id' => 3],
            [
                'judul' => 'Publikasi Badan Bank Tanah',
                'isi' => 'Informasi resmi dan terkini mengenai kegiatan, kebijakan, dan pengumuman Badan Bank Tanah. Temukan berita, siaran pers, dan pengumuman resmi dalam satu tempat.',
                'visi' => null,
                'misi' => null,
                'struktur_organisasi' => null,
                'dasar_hukum' => null,
                'gambar' => null,
                'foto' => null,
                'is_active' => true,
                'slug' => 'publikasi-badan-bank-tanah',
                'meta_title' => 'Publikasi Badan Bank Tanah',
                'meta_description' => 'Informasi resmi dan terkini mengenai kegiatan, kebijakan, dan pengumuman Badan Bank Tanah.',
            ]
        );

        // =========================================================
        // MENU NAVIGASI
        // =========================================================
        $menus = [
            ['nama' => 'Beranda', 'link' => '/', 'status' => 'Aktif'],
            ['nama' => 'Tentang', 'link' => '/tentang', 'status' => 'Aktif'],
            ['nama' => 'Aset Persediaan Tanah', 'link' => '/aset', 'status' => 'Aktif'],
            ['nama' => 'Pemanfaatan & Kerjasama', 'link' => '/pemanfaatan', 'status' => 'Aktif'],
            ['nama' => 'Publikasi', 'link' => '/publikasi', 'status' => 'Aktif'],
            ['nama' => 'FAQ', 'link' => '/faq', 'status' => 'Aktif'],
            ['nama' => 'Karier', 'link' => '/karier', 'status' => 'Aktif'],
            ['nama' => 'Kontak', 'link' => '/kontak', 'status' => 'Aktif'],
        ];

        foreach ($menus as $menu) {
            MenuNavigasi::updateOrCreate(
                ['nama' => $menu['nama']],
                $menu
            );
        }

        // =========================================================
        // DATA ASET TANAH
        // =========================================================
        $asets = [
            [
                'nama_lokasi' => 'Kawasan Industri Terpadu Batang',
                'provinsi' => 'Jawa Tengah',
                'kabupaten' => 'Batang',
                'luas_hektar' => 2450.00,
                'peruntukan' => 'Industri',
                'skema' => 'Sewa',
                'status' => 'Tersedia',
                'gambar' => null,
                'lat' => -6.9,
                'lng' => 109.7,
                'deskripsi' => 'Kawasan Industri Terpadu Batang (KITB) adalah kawasan industri strategis yang dikembangkan untuk mendukung investasi dan hilirisasi industri di Jawa Tengah.',
            ],
            [
                'nama_lokasi' => 'Tanah Bekas HGU PT. Sinar Harapan',
                'provinsi' => 'Sumatera Selatan',
                'kabupaten' => 'Musi Banyuasin',
                'luas_hektar' => 1850.50,
                'peruntukan' => 'Pertanian',
                'skema' => 'Kerjasama',
                'status' => 'Dalam Pengembangan',
                'gambar' => null,
                'lat' => -3.3,
                'lng' => 114.5,
                'deskripsi' => 'Tanah eks HGU seluas 1.850 Hektar yang sedang dalam proses pengembangan untuk mendukung program ketahanan pangan nasional.',
            ],
            [
                'nama_lokasi' => 'Kawasan Sentra Pangan Merauke',
                'provinsi' => 'Papua Selatan',
                'kabupaten' => 'Merauke',
                'luas_hektar' => 5320.75,
                'peruntukan' => 'Pertanian',
                'skema' => 'Sewa',
                'status' => 'Tersedia',
                'gambar' => null,
                'lat' => -8.5,
                'lng' => 140.4,
                'deskripsi' => 'Kawasan Sentra Pangan Merauke merupakan lahan pertanian skala besar yang berada di Kabupaten Merauke.',
            ],
        ];

        foreach ($asets as $aset) {
            AsetTanah::updateOrCreate(
                ['nama_lokasi' => $aset['nama_lokasi']],
                $aset
            );
        }

        // =========================================================
        // DATA BERITA
        // =========================================================
        $berita = [
            [
                'judul' => 'Peluang Investasi di Kawasan Strategis Nasional',
                'slug' => 'peluang-investasi-di-kawasan-strategis-nasional',
                'ringkasan' => 'Badan Bank Tanah membuka peluang investasi bagi investor di berbagai kawasan strategis.',
                'konten' => 'Badan Bank Tanah membuka peluang investasi bagi investor di berbagai kawasan strategis. Kawasan ini memiliki potensi besar untuk dikembangkan.',
                'kategori' => 'Berita',
                'penulis' => 'Admin',
                'views' => 1245,
                'status' => 'Dipublikasikan',
                'status_approval' => 'Dipublikasikan',
                'gambar' => null,
                'tanggal_publikasi' => now(),
            ],
            [
                'judul' => 'Siaran Pers: Kolaborasi dengan Pemerintah Daerah',
                'slug' => 'siaran-pers-kolaborasi-dengan-pemerintah-daerah',
                'ringkasan' => 'Badan Bank Tanah memperkuat kolaborasi dengan pemerintah daerah untuk optimalisasi aset.',
                'konten' => 'Badan Bank Tanah memperkuat kolaborasi dengan pemerintah daerah untuk optimalisasi aset.',
                'kategori' => 'Siaran Pers',
                'penulis' => 'Admin',
                'views' => 800,
                'status' => 'Dipublikasikan',
                'status_approval' => 'Dipublikasikan',
                'gambar' => null,
                'tanggal_publikasi' => now(),
            ],
            [
                'judul' => 'Optimalisasi Aset Tanah untuk Mendukung Pembangunan Nasional',
                'slug' => 'optimalisasi-aset-tanah-untuk-mendukung-pembangunan-nasional',
                'ringkasan' => 'Badan Bank Tanah terus mendorong optimalisasi aset tanah untuk mendukung pembangunan nasional.',
                'konten' => 'Badan Bank Tanah terus mendorong optimalisasi aset tanah melalui pemanfaatan yang produktif, berkelanjutan, dan memberikan manfaat bagi masyarakat.',
                'kategori' => 'Berita',
                'penulis' => 'Admin',
                'views' => 650,
                'status' => 'Dipublikasikan',
                'status_approval' => 'Dipublikasikan',
                'gambar' => null,
                'tanggal_publikasi' => now(),
            ],
        ];

        foreach ($berita as $item) {
            Berita::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}