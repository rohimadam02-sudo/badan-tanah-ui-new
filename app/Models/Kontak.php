<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    // PERBAIKI: Gunakan 'kontak' (singular) sesuai tabel di database
    protected $table = 'kontak';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'pesan',
        'is_read',
    ];
}