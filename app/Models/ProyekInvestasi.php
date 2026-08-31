<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekInvestasi extends Model
{
    use HasFactory;

    protected $table = 'proyek_investasi';

    protected $fillable = [
        'judul',
        'lokasi',
        'sektor',
        'nilai_investasi',
        'status',
        'deskripsi',
        'gambar',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'nilai_investasi' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}