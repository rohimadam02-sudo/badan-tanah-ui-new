<?php

/* =========================================================
    NAMESPACE & IMPORT
========================================================= */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* =========================================================
    MODEL: DOKUMEN KERJASAMA
========================================================= */
class DokumenKerjasama extends Model
{
    use HasFactory;

    /* =========================================================
        NAMA TABEL
    ========================================================= */
    protected $table = 'dokumen_kerjasama';

    /* =========================================================
        KOLOM YANG DAPAT DIISI (MASS ASSIGNMENT)
    ========================================================= */
    protected $fillable = [
        'judul',
        'file_path',
        'ukuran',
        'kategori',
        'is_active',
        'urutan',
    ];

    /* =========================================================
        CASTING ATTRIBUTE
    ========================================================= */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}