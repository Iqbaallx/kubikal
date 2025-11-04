<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Menu;
use App\Models\Event; // Pastikan ini di-import

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get current tab from query parameter (default: menu)
        $currentTab = $request->query('tab', 'menu');
        
        // 1. Ambil SEMUA menu
        $menus = Menu::orderBy('id_menu', 'desc')->get();
        
        // 2. Ambil SEMUA event (diurutkan dari yang terbaru)
        $events = Event::orderBy('id_event', 'desc')->get(); // <-- DIUBAH

        // Hitung statistik menu
        $stats = [
            'totalMenu' => $menus->count(),
            'minuman' => $menus->where('kategori', 'Minuman')->count(),
            'makanan' => $menus->where('kategori', 'Makanan')->count(),
            'favorit' => $menus->where('favorit', true)->count(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'menus' => $menus,
            'stats' => $stats,
            'events' => $events, // <-- DIUBAH (dari 'event' menjadi 'events')
            'currentTab' => $currentTab
        ]);
    }
}