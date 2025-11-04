<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Event; // <-- Pastikan Event di-import
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Menampilkan data untuk Halaman Home (Home.vue).
     */
    public function index()
    {
        // ==================================
        // === PERBAIKAN DI SINI ===
        // ==================================
        
        // 1. Ambil Menu Favorit (dimana favorit = 'Y')
        // Kita batasi 4 menu saja untuk di Home (sesuai desain)
        $favoriteMenus = Menu::where('favorit', 'Y') //
                            ->orderBy('updated_at', 'desc')
                            ->take(4)
                            ->get();

        // 2. Ambil SEMUA event, diurutkan dari yang terbaru
        $events = Event::orderBy('tanggal', 'desc')->get(); //

        // 3. Kirim data (termasuk favoriteMenus) ke komponen Home.vue
        return Inertia::render('Home', [
            'events' => $events,
            'favoriteMenus' => $favoriteMenus, // <-- DATA BARU
            // canLogin & canRegister dikirim otomatis oleh HandleInertiaRequests.php
        ]);
    }

    /**
     * Menampilkan data untuk Halaman Menu (HalamanMenu.vue).
     * (Ini sudah benar dari langkah sebelumnya)
     */
    public function showMenu()
    {
        $allMenus = Menu::all();

        // Pisahkan menu berdasarkan kategori database
        $menus = [
            'makanan' => $allMenus->whereIn('kategori', ['makanan', 'camilan'])->values(), //
            'minuman' => $allMenus->whereIn('kategori', ['coffee', 'non-coffee'])->values(), //
        ];

        return Inertia::render('HalamanMenu', [
            'menus' => $menus,
        ]);
    }

    // Fungsi CRUD (store, update, destroy) tidak diperlukan di sini
    // karena sudah ditangani oleh AdminMenuController
}