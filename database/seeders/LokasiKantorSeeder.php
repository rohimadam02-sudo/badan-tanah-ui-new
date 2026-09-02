<?php

namespace Database\Seeders;

use App\Models\LokasiKantor;
use Illuminate\Database\Seeder;

class LokasiKantorSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            [
                'nama' => 'Kantor Pusat Badan Bank Tanah',
                'alamat' => 'Jl. H. Juanda No. 15, Jakarta Pusat',
                'lat' => -6.1754,
                'lng' => 106.8272,
                'telepon' => '(021) 3456-7890',
                'email' => 'info@bantah.go.id',
                'icon' => 'fa-building',
                'warna' => '#006400',
                'urutan' => 0,
                'is_active' => true,
                'is_utama' => true,
                'deskripsi' => 'Kantor pusat Badan Bank Tanah',
                'jam_kerja' => 'Senin-Jumat: 08:00 - 16:00',
            ],
        ];

        foreach ($defaults as $data) {
            LokasiKantor::updateOrCreate(
                ['nama' => $data['nama']],
                $data
            );
        }
    }
}