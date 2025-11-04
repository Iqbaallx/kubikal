<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    protected $table = 'event';
    protected $primaryKey = 'id_event';

    // HAPUS BARIS INI KARENA MIGRATION ANDA MEMILIKI TIMESTAMPS
    // public $timestamps = false; 

    /**
     * SESUAIKAN DENGAN NAMA KOLOM DARI MIGRASI
     */
    protected $fillable = [
        'nama_event',
        'deskripsi_event',
        'tanggal', // <-- DIUBAH
        'waktu',   // <-- DIUBAH
        'gambar_event',
    ];

    // Accessor untuk URL gambar
    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute()
    {
        return $this->gambar_event
            ? asset('storage/' . $this->gambar_event)
            : null;
    }
}