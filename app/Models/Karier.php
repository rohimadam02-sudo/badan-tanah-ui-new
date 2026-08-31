<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karier extends Model
{
    use HasFactory;

    protected $table = 'kariers';

    protected $fillable = [
        'judul',
        'deskripsi',
        'kualifikasi',
        'lokasi',
        'status',
    ];
}