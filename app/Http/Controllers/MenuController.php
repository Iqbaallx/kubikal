<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Event;
use App\Models\Galeri; 
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{

    public function index()
    {

        $favoriteMenus = Menu::where('favorit', 'Y')
                            ->orderBy('updated_at', 'desc')
                            ->take(4)
                            ->get();

        // Hanya tampilkan event yang masih aktif/upcoming (tanggal_selesai >= hari ini)
        $events = Event::where('tanggal_selesai', '>=', now()->toDateString())
                       ->orderBy('tanggal_mulai', 'asc')
                       ->take(3)
                       ->get();

        // Ambil gambar yang difavoritkan untuk Home
        $favorites = Galeri::where('is_favorite', true)
                        ->latest()
                        ->take(8) // Ambil cukup banyak untuk display, misal 8
                        ->get();
        
        return Inertia::render('Home', [
            'events' => $events,
            'favoriteMenus' => $favoriteMenus,
            'galleries' => [
                'favorites' => $favorites, 
            ],
        ]);
    }

    public function gallery()
    {
        // Ambil semua gambar untuk halaman Gallery (termasuk yang difavoritkan)
        $images = Galeri::latest()->get();

        return Inertia::render('Gallery', [
            'images' => $images
        ]);
    }
    public function showMenu()
    {
        $allMenus = Menu::all();

        $menus = [
            'makanan' => $allMenus->whereIn('kategori', ['makanan', 'camilan'])->values(),
            'minuman' => $allMenus->whereIn('kategori', ['coffee', 'non-coffee'])->values(),
        ];

        return Inertia::render('HalamanMenu', [
            'menus' => $menus,
        ]);
    }
}