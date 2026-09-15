<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenKerjasama extends Model
{
    use HasFactory;

    protected $table = 'dokumen_kerjasama';

    protected $fillable = [
        'judul',
        'file_path',
        'ukuran',
        'kategori',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}