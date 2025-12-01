<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';

    protected $fillable = ['gambar', 'tipe'];

    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }
}