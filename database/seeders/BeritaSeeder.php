<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        Berita::create([
            'judul' => 'Peluang Investasi di Kawasan Strategis Nasional',
            'slug' => 'peluang-investasi-di-kawasan-strategis-nasional',
            'ringkasan' => 'Badan Bank Tanah membuka peluang investasi bagi investor di berbagai kawasan strategis.',
            'konten' => 'Badan Bank Tanah membuka peluang investasi bagi investor di berbagai kawasan strategis. Kawasan ini memiliki potensi besar untuk dikembangkan.',
            'kategori' => 'Berita',
            'penulis' => 'Admin',
            'views' => 1245,
            'status' => 'Dipublikasikan',
            'tanggal_publikasi' => now(),
        ]);

        Berita::create([
            'judul' => 'Siaran Pers: Kolaborasi dengan Pemerintah Daerah',
            'slug' => 'siaran-pers-kolaborasi-dengan-pemerintah-daerah',
            'ringkasan' => 'Badan Bank Tanah memperkuat kolaborasi dengan pemerintah daerah untuk optimalisasi aset.',
            'konten' => 'Badan Bank Tanah memperkuat kolaborasi com/pemerintah daerah untuk optimalisasi aset.',
            'kategori' => 'Siaran Pers',
            'penulis' => 'Admin',
            'views' => 800,
            'status' => 'Dipublikasikan',
            'tanggal_publikasi' => now(),
        ]);

        Berita::create([
            'judul' => 'Optimalisasi Aset Tanah untuk Mendukung Pembangunan Nasional',
            'slug' => 'optimalisasi-aset-tanah-untuk-mendukung-pembangunan-nasional',
            'ringkasan' => 'Badan Bank Tanah terus mendorong optimalisasi aset tanah untuk mendukung pembangunan nasional.',
            'konten' => 'Badan Bank Tanah terus mendorong optimalisasi aset tanah melalui pemanfaatan yang produktif, berkelanjutan, dan memberikan manfaat bagi masyarakat serta mendukung pembangunan nasional.',
            'kategori' => 'Berita',
            'penulis' => 'Admin',
            'views' => 650,
            'status' => 'Dipublikasikan',
            'gambar' => null,
            'tanggal_publikasi' => now(),
        ]);

    }
}
