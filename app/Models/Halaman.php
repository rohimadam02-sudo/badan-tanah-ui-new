<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    use HasFactory;

    protected $table = 'halaman';

    protected $fillable = [
        'judul',
        'isi',
        'visi',
        'misi',
        'struktur_organisasi',
        'dasar_hukum',
        'gambar',
        'foto',
        'is_active',
        'slug',
        'meta_title',
        'meta_description',
        'skema_pemanfaatan',
        'bentuk_kerjasama',
        'prosedur_tahapan',
        'persyaratan',
        'dokumen_pendukung',
        'faq_pemanfaatan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'skema_pemanfaatan' => 'array',
        'bentuk_kerjasama' => 'array',
        'prosedur_tahapan' => 'array',
        'persyaratan' => 'array',
        'dokumen_pendukung' => 'array',
        'faq_pemanfaatan' => 'array',
    ];

    /**
     * Get the hero image URL
     */
    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return null;
    }

    /**
     * Get the foto URL
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }

    /**
     * Scope for active pages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the page type label
     */
    public function getTypeLabelAttribute()
    {
        if (str_contains($this->judul, 'Tentang')) {
            return 'Halaman Tentang';
        } elseif (str_contains($this->judul, 'Pemanfaatan')) {
            return 'Halaman Pemanfaatan';
        } elseif (str_contains($this->judul, 'Publikasi')) {
            return 'Halaman Publikasi';
        }
        return 'Halaman Statis';
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return $this->is_active 
            ? '<span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700">Aktif</span>'
            : '<span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-50 text-gray-500">Tidak Aktif</span>';
    }

    /**
     * Get the frontend URL for this page
     */
    public function getFrontendUrlAttribute()
    {
        return match(true) {
            str_contains($this->judul, 'Tentang') => route('about'),
            str_contains($this->judul, 'Pemanfaatan') => route('partnership'),
            str_contains($this->judul, 'Publikasi') => route('halaman.publikasi'),
            default => '#'
        };
    }

    /**
     * Accessor untuk memastikan data selalu dalam bentuk array
     */
    public function getSkemaPemanfaatanAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        return json_decode($value, true) ?? [];
    }

    public function getBentukKerjasamaAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        return json_decode($value, true) ?? [];
    }

    public function getProsedurTahapanAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        return json_decode($value, true) ?? [];
    }

    public function getPersyaratanAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        return json_decode($value, true) ?? [];
    }

    public function getDokumenPendukungAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        return json_decode($value, true) ?? [];
    }

    public function getFaqPemanfaatanAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        return json_decode($value, true) ?? [];
    }
}