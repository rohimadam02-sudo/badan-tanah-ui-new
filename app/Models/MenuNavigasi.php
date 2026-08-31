<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuNavigasi extends Model
{
    use HasFactory;

    protected $table = 'menu_navigasi';

    protected $fillable = [
        'nama',
        'link',
        'status',
    ];
}