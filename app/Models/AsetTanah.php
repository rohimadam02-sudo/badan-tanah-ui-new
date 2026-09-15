<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Laravel\Scout\Searchable;
use App\Helpers\CacheHelper;

class AsetTanah extends Model
{
    use HasFactory, LogsActivity, Searchable;

    protected $table = 'aset_tanah';

    protected $fillable = [
        'nama_lokasi',
        'provinsi',
        'kabupaten',
        'luas_hektar',
        'peruntukan',
        'skema',
        'status',
        'deskripsi',
        'lat',
        'lng',
        'gambar',
        'dokumen',
        'dokumen_files',
        'meta_title',
        'meta_description',
        'qr_code',
    ];

    protected $casts = [
        'dokumen' => 'array',
        'dokumen_files' => 'array',
    ];

    // =========================================================
    // BOOT - Auto generate SEO & Cache Invalidation
    // =========================================================
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->generateSEO();
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama_lokasi') || $model->isDirty('deskripsi')) {
                $model->generateSEO();
            }
        });

        // Cache invalidation ketika data berubah
        static::saved(function ($model) {
            CacheHelper::forgetMany([
                'home_asets',
                'aset_data',
                'aset_filter_all',
                'aset_detail_' . $model->id,
            ]);
        });

        static::deleted(function ($model) {
            CacheHelper::forgetMany([
                'home_asets',
                'aset_data',
                'aset_filter_all',
                'aset_detail_' . $model->id,
            ]);
        });
    }

    /**
     * Auto-generate SEO metadata
     */
    public function generateSEO()
    {
        // Generate meta_title dari nama_lokasi
        if (empty($this->meta_title)) {
            $this->meta_title = $this->nama_lokasi . ' - Aset Tanah Badan Bank Tanah';
        }

        // Generate meta_description dari deskripsi atau gabungan data
        if (empty($this->meta_description)) {
            $text = $this->deskripsi ?? '';
            if (empty($text)) {
                $text = 'Aset tanah di ' . $this->provinsi . ', ' . $this->kabupaten . 
                        ' dengan luas ' . number_format($this->luas_hektar, 2, ',', '.') . ' Ha. ' .
                        'Peruntukan: ' . ($this->peruntukan ?? '-') . '. ' .
                        'Status: ' . $this->status . '.';
            }
            $text = preg_replace('/\s+/', ' ', trim($text));
            $this->meta_description = \Illuminate\Support\Str::limit($text, 160, '...');
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama_lokasi', 'status', 'provinsi'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'nama_lokasi' => $this->nama_lokasi,
            'provinsi' => $this->provinsi,
            'kabupaten' => $this->kabupaten,
            'deskripsi' => strip_tags($this->deskripsi ?? ''),
            'peruntukan' => $this->peruntukan,
            'skema' => $this->skema,
            'status' => $this->status,
            'luas_hektar' => $this->luas_hektar,
        ];
    }

    public function searchableAs(): string
    {
        return 'aset_index';
    }

    public function getImageUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return null;
    }

    public function getDokumenListAttribute()
    {
        return $this->dokumen ?? [];
    }

    public function getDokumenFilesListAttribute()
    {
        return $this->dokumen_files ?? [];
    }
}