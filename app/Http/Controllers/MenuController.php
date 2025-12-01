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

        $events = Event::orderBy('tanggal', 'desc')
                       ->take(3)
                       ->get();

        $favorites = Galeri::where('is_favorite', true)
                        ->latest()
                        ->take(4)
                        ->get();
        
        $allGalleries = Galeri::latest()->get();

        return Inertia::render('Home', [
            'events' => $events,
            'favoriteMenus' => $favoriteMenus,
            'galleries' => [
                'favorites' => $favorites, 
                'all' => $allGalleries,
            ],
        ]);
    }

    public function gallery()
    {

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