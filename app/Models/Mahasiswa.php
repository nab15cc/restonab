<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
 use HasFactory;
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_menu';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_menu',
        'nama_menu',
        'kategori',
        'harga',
        'deskripsi'
    ];
 
}
