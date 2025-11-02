<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User; // Contoh jika Anda ingin mengambil data user

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     */
    public function index(Request $request)
    {
        // Di sini Anda bisa mengambil data apa pun yang
        // diperlukan untuk ditampilkan di dashboard.
        // Contoh:
        // $totalUsers = User::count();
        // $totalSales = ...

        // Render komponen Vue 'Admin/Dashboard.vue'
        // dan kirim props (data) ke dalamnya.
        return Inertia::render('Admin/Dashboard', [
            // 'stats' => [
            //     'totalUsers' => $totalUsers,
            // ]
        ]);
    }
}