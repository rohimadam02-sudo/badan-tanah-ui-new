<?php

/* =========================================================
    NAMESPACE & IMPORT
========================================================= */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* =========================================================
    MODEL: LOKASI KANTOR
========================================================= */
class LokasiKantor extends Model
{
    use HasFactory;

    /* =========================================================
        NAMA TABEL
    ========================================================= */
    protected $table = 'lokasi_kantor';

    /* =========================================================
        KOLOM YANG DAPAT DIISI (MASS ASSIGNMENT)
    ========================================================= */
    protected $fillable = [
        'nama',
        'alamat',
        'lat',
        'lng',
        'telepon',
        'email',
        'icon',
        'warna',
        'urutan',
        'is_active',
        'is_utama',
        'deskripsi',
        'jam_kerja',
    ];

    /* =========================================================
        CASTING ATTRIBUTE
    ========================================================= */
    protected $casts = [
        'is_active' => 'boolean',
        'is_utama' => 'boolean',
        'urutan' => 'integer',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
    ];

    /* =========================================================
        SCOPE: FILTER AKTIF
    ========================================================= */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /* =========================================================
        SCOPE: URUTAN (UTAMA DULU, LALU URUTAN)
    ========================================================= */
    public function scopeOrdered($query)
    {
        return $query->orderBy('is_utama', 'desc')->orderBy('urutan', 'asc');
    }

    /* =========================================================
        ACCESSOR: WARNA MARKER
    ========================================================= */
    public function getMarkerColorAttribute()
    {
        return $this->warna ?? '#006400';
    }

    /* =========================================================
        ACCESSOR: ICON MARKER
    ========================================================= */
    public function getMarkerIconAttribute()
    {
        return $this->icon ?? 'fa-building';
    }

    /* =========================================================
        ACCESSOR: ALAMAT LENGKAP
    ========================================================= */
    public function getFullAddressAttribute()
    {
        return $this->alamat . ($this->telepon ? ' (Telp: ' . $this->telepon . ')' : '');
    }
}