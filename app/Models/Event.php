<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';
    protected $primaryKey = 'id_event';
    public $timestamps = false;

    protected $fillable = [
        'nama_event',
        'deskripsi_event',
        'tanggal',
        'waktu',
        'gambar_event',
    ];

    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute()
    {
        return $this->gambar_event
            ? asset('storage/' . $this->gambar_event)
            : null;
    }
}
