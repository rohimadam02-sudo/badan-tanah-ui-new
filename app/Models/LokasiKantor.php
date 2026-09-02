<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKantor extends Model
{
    use HasFactory;

    protected $table = 'lokasi_kantor';

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

    protected $casts = [
        'is_active' => 'boolean',
        'is_utama' => 'boolean',
        'urutan' => 'integer',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('is_utama', 'desc')->orderBy('urutan', 'asc');
    }

    public function getMarkerColorAttribute()
    {
        return $this->warna ?? '#006400';
    }

    public function getMarkerIconAttribute()
    {
        return $this->icon ?? 'fa-building';
    }

    public function getFullAddressAttribute()
    {
        return $this->alamat . ($this->telepon ? ' (Telp: ' . $this->telepon . ')' : '');
    }
}