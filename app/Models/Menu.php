<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    
    // HAPUS BARIS INI KARENA MIGRATION ANDA MEMILIKI TIMESTAMPS
    // public $timestamps = false; 

    protected $fillable = [
        'nama_menu',
        'deskripsi_menu',
        'harga_menu',
        'kategori',
        'favorit',
        'gambar_menu',
    ];

    /**
     * TAMBAHKAN INI UNTUK MENGUBAH Y/N DARI DATABASE
     * MENJADI TRUE/FALSE UNTUK VUE.JS
     */
    protected $casts = [
        'favorit' => \App\Casts\YesNoCast::class, // Kita akan buat file cast ini
        'harga_menu' => 'decimal:2',
    ];

    // 🟢 Jika ingin akses URL gambar langsung dari Vue:
    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute()
    {
        return $this->gambar_menu
            ? asset('storage/' . $this->gambar_menu)
            : null;
    }
}