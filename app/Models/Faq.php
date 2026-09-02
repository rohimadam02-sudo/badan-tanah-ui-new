<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = [
        'pertanyaan',
        'kategori', // TAMBAHKAN
        'jawaban',
    ];

    /**
     * Get all unique categories
     */
    public static function getCategories()
    {
        return self::select('kategori')
            ->distinct()
            ->pluck('kategori')
            ->toArray();
    }

    /**
     * Scope for category filter
     */
    public function scopeKategori($query, $kategori)
    {
        if ($kategori && $kategori !== 'Semua') {
            return $query->where('kategori', $kategori);
        }
        return $query;
    }
}