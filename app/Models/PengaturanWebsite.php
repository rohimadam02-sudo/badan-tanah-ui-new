<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanWebsite extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_websites';

    protected $fillable = [
        'judul_hero',
        'subjudul_hero',
        'tombol_text',
        'tombol_link',
        'warna_utama',
        'warna_sekunder',
        'nama_website',
        'deskripsi_website',
        'logo',
        'google_analytics',
        'kimi_api_key',
        'qr_enabled',
        'maintenance_mode',
        'meta_title_default',
        'meta_description_default',
        'keywords',
        'timezone',
        'bahasa',
    ];

    protected $casts = [
        'qr_enabled' => 'boolean',
        'maintenance_mode' => 'boolean',
    ];
}