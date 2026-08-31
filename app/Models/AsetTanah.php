<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Laravel\Scout\Searchable;

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
        'dokumen_files', // TAMBAHKAN INI UNTUK FILE DOKUMEN
    ];

    protected $casts = [
        'dokumen' => 'array',
        'dokumen_files' => 'array', // TAMBAHKAN INI UNTUK FILE DOKUMEN
    ];

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