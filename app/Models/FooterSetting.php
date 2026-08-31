<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $table = 'footer_settings';

    protected $fillable = [
        'nama_website',
        'deskripsi',
        'alamat',
        'email',
        'telepon',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'youtube',
        'footer_text',
        'show_social_media',
        'show_newsletter',
        'quick_links',
    ];

    protected $casts = [
        'quick_links' => 'array',
        'show_social_media' => 'boolean',
        'show_newsletter' => 'boolean',
    ];

    /**
     * Get the first footer setting or create default
     */
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([
                'nama_website' => 'Badan Bank Tanah',
                'deskripsi' => 'Mengelola tanah negara secara profesional, transparan, dan berkelanjutan untuk kepentingan rakyat.',
                'alamat' => 'Jl. H. Juanda No. 15, Jakarta Pusat',
                'email' => 'info@bantah.go.id',
                'telepon' => '(021) 3456-7890',
                'facebook' => '#',
                'instagram' => '#',
                'twitter' => '#',
                'linkedin' => '#',
                'youtube' => '#',
                'footer_text' => '&copy; {year} Badan Bank Tanah. Hak Cipta Dilindungi.',
                'show_social_media' => true,
                'show_newsletter' => true,
                'quick_links' => [
                    ['label' => 'Tentang Kami', 'url' => '/tentang'],
                    ['label' => 'Aset Persediaan', 'url' => '/aset'],
                    ['label' => 'Pemanfaatan & Kerjasama', 'url' => '/pemanfaatan'],
                    ['label' => 'Publikasi', 'url' => '/publikasi'],
                    ['label' => 'FAQ', 'url' => '/faq'],
                    ['label' => 'Karier', 'url' => '/karier'],
                    ['label' => 'Kontak', 'url' => '/kontak'],
                ],
            ]);
        }
        
        return $settings;
    }
}