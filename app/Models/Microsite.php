<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Microsite extends Model
{
    use HasFactory;

    protected $table = 'microsites';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'meta_title',
        'meta_description',
        'is_active',
        'is_featured',
        'tanggal_mulai',
        'tanggal_selesai',
        'custom_css',
        'custom_js',
        'views',
        'layout',
        'seo_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'views' => 'integer',
    ];

    // =========================================================
    // BOOT - Auto generate slug
    // =========================================================
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->judul);
            }
            if (empty($model->meta_title)) {
                $model->meta_title = $model->judul . ' - Badan Bank Tanah';
            }
            if (empty($model->meta_description)) {
                $model->meta_description = Str::limit(strip_tags($model->konten), 160, '...');
            }
        });
    }

    /**
     * Get the microsite's URL
     */
    public function getUrlAttribute()
    {
        return route('microsite.show', $this->slug);
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return null;
    }

    /**
     * Scope for active microsites
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured microsites
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for upcoming/ongoing events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_selesai', '>=', now());
    }
}