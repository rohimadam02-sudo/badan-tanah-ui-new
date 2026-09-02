<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $table = 'social_media';

    protected $fillable = [
        'nama',
        'icon',
        'url',
        'warna',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Scope untuk yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc');
    }

    /**
     * Get icon color
     */
    public function getColorAttribute()
    {
        return $this->warna ?? '#ffffff';
    }

    /**
     * Get default icons
     */
    public static function getDefaultIcons()
    {
        return [
            ['nama' => 'YouTube', 'icon' => 'fab fa-youtube', 'url' => '#', 'warna' => '#FF0000', 'urutan' => 0, 'is_active' => true],
            ['nama' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => '#', 'warna' => '#E4405F', 'urutan' => 1, 'is_active' => true],
            ['nama' => 'TikTok', 'icon' => 'fab fa-tiktok', 'url' => '#', 'warna' => '#000000', 'urutan' => 2, 'is_active' => true],
            ['nama' => 'LinkedIn', 'icon' => 'fab fa-linkedin-in', 'url' => '#', 'warna' => '#0A66C2', 'urutan' => 3, 'is_active' => true],
        ];
    }
}