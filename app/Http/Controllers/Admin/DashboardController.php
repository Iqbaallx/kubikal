<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get current tab from query parameter (default: menu)
        $currentTab = $request->query('tab', 'menu');
        
        // TODO: Ganti dengan query database sebenarnya
        // Contoh: $menus = Menu::all();
        
        // Data dummy untuk menu
        $menus = [
            [
                'id' => 1,
                'foto' => '☕',
                'foto_url' => null,
                'nama' => 'Espresso',
                'kategori' => 'Minuman',
                'harga' => 25000,
                'deskripsi' => 'Kopi susu murni',
                'favorit' => true
            ],
            [
                'id' => 2,
                'foto' => '☕',
                'foto_url' => null,
                'nama' => 'Latte',
                'kategori' => 'Minuman',
                'harga' => 28000,
                'deskripsi' => 'Kopi dengan susu foam',
                'favorit' => false
            ],
            [
                'id' => 3,
                'foto' => '🥐',
                'foto_url' => null,
                'nama' => 'Croissant',
                'kategori' => 'Makanan',
                'harga' => 25000,
                'deskripsi' => 'Roti lapis mentega',
                'favorit' => false
            ],
            [
                'id' => 4,
                'foto' => '🥤',
                'foto_url' => null,
                'nama' => 'Ice Tea',
                'kategori' => 'Minuman',
                'harga' => 15000,
                'deskripsi' => 'Teh dingin segar',
                'favorit' => false
            ],
        ];

        // Hitung statistik
        $stats = [
            'totalMenu' => count($menus),
            'minuman' => count(array_filter($menus, fn($m) => $m['kategori'] === 'Minuman')),
            'makanan' => count(array_filter($menus, fn($m) => $m['kategori'] === 'Makanan')),
            'favorit' => count(array_filter($menus, fn($m) => $m['favorit'] === true)),
        ];

        // Data event dummy
        $event = [
            'id' => 1,
            'nama' => 'Diskon Kemerdekaan',
            'tanggal' => '2024-08-17',
            'waktu' => '10:00',
            'deskripsi' => 'Nikmati diskon spesial untuk merayakan Hari Kemerdekaan! Dapatkan potongan harga 17% untuk semua minuman.',
            'gambar_url' => null
        ];

        return Inertia::render('Admin/Dashboard', [
            'menus' => $menus,
            'stats' => $stats,
            'event' => $event,
            'currentTab' => $currentTab // Pass current tab to frontend
        ]);
    }
}