<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $fillable = [
        'id_komponen_gaji',
        'id_anggota',
    ];
}
