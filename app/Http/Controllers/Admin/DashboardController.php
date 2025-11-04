<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Menu;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get current tab from query parameter (default: menu)
        $currentTab = $request->query('tab', 'menu');
        
        // Ambil semua data menu
        $menus = Menu::orderBy('id_menu', 'desc')->get();
        
        // Ambil semua data event
        $events = Event::orderBy('id_event', 'desc')->get();

        // ==================================
        // === PERBAIKAN LOGIKA STATISTIK ===
        // ==================================
        
        // Kategori database Anda adalah ['coffee', 'non-coffee', 'makanan', 'camilan']
        
        $stats = [
            'totalMenu' => $menus->count(),
            
            // Hitung 'coffee' + 'non-coffee' sebagai 'minuman'
            'minuman' => $menus->whereIn('kategori', ['coffee', 'non-coffee'])->count(),
            
            // Hitung 'makanan' + 'camilan' sebagai 'makanan'
            'makanan' => $menus->whereIn('kategori', ['makanan', 'camilan'])->count(),
            
            // Cast 'Y'/'N' menjadi true/false
            'favorit' => $menus->where('favorit', true)->count(), 
        ];
        // ==================================

        return Inertia::render('Admin/Dashboard', [
            'menus' => $menus,
            'stats' => $stats, // Kirim stats yang sudah benar
            'events' => $events,
            'currentTab' => $currentTab
        ]);
    }
}