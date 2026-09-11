<?php

/* =========================================================
    NAMESPACE & IMPORT
========================================================= */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* =========================================================
    MODEL: MENU NAVIGASI
========================================================= */
class MenuNavigasi extends Model
{
    use HasFactory;

    /* =========================================================
        NAMA TABEL
    ========================================================= */
    protected $table = 'menu_navigasi';

    /* =========================================================
        KOLOM YANG DAPAT DIISI (MASS ASSIGNMENT)
    ========================================================= */
    protected $fillable = [
        'nama',
        'link',
        'status',
    ];
}