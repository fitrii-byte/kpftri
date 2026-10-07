<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['judul', 'deskripsi', 'link', 'gambar', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];
}
