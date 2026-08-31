<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AsetTanah;

class AsetTanahSeeder extends Seeder
{
    public function run()
    {
        AsetTanah::create([
            'nama_lokasi' => 'Kawasan Industri Terpadu Batang',
            'provinsi' => 'Jawa Tengah',
            'kabupaten' => 'Batang',
            'luas_hektar' => 2450.00,
            'peruntukan' => 'Industri',
            'skema' => 'Sewa',
            'status' => 'Tersedia',
        ]);

        AsetTanah::create([
            'nama_lokasi' => 'Tanah Bekas HGU PT. Sinar Harapan',
            'provinsi' => 'Sumatera Selatan',
            'kabupaten' => 'Musi Banyuasin',
            'luas_hektar' => 1850.50,
            'peruntukan' => 'Pertanian',
            'skema' => 'Kerjasama',
            'status' => 'Dalam Pengembangan',
        ]);

        AsetTanah::create([
            'nama_lokasi' => 'Kawasan Sentra Pangan Merauke',
            'provinsi' => 'Papua Selatan',
            'kabupaten' => 'Merauke',
            'luas_hektar' => 5320.75,
            'peruntukan' => 'Pertanian',
            'skema' => 'Sewa',
            'status' => 'Tersedia',
        ]);
    }
}