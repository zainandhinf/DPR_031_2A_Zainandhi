<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomponenGaji extends Model
{
    protected $table = 'komponen_gajis';
    protected $primaryKey = 'id_komponen_gaji';
    public $incrementing = true;
    protected $keyType = 'int'; 
    protected $fillable = [
        'id_komponen_gaji',
        'nama_komponen',
        'kategori',
        'jabatan',
        'nominal',
        'satuan',
    ];
}
