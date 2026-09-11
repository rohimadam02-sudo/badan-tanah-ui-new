<?php

/* =========================================================
    NAMESPACE & IMPORT
========================================================= */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* =========================================================
    MODEL: LAMARAN
========================================================= */
class Lamaran extends Model
{
    use HasFactory;

    /* =========================================================
        NAMA TABEL
    ========================================================= */
    protected $table = 'lamaran';

    /* =========================================================
        KOLOM YANG DAPAT DIISI (MASS ASSIGNMENT)
    ========================================================= */
    protected $fillable = [
        'karier_id',
        'nama',
        'email',
        'telepon',
        'cv',
        'pesan',
        'status',
        'is_read',
    ];

    /* =========================================================
        CASTING ATTRIBUTE
    ========================================================= */
    protected $casts = [
        'is_read' => 'boolean',
    ];

    /* =========================================================
        RELASI: LAMARAN MILIK KARIER
    ========================================================= */
    public function karier()
    {
        return $this->belongsTo(Karier::class);
    }
}