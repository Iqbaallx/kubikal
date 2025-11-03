<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    public $timestamps = false;

    protected $fillable = [
        'nama_menu',
        'deskripsi_menu',
        'harga_menu',
        'kategori',
        'favorit',
        'gambar_menu',
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
