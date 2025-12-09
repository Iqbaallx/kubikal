<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Menu/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi ini sudah benar dari sebelumnya
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori' => 'required|in:coffee,non-coffee,makanan,camilan',
            'harga_menu' => 'required|numeric|min:0',
            'deskripsi_menu' => 'required|string',
            'gambar_menu' => 'nullable|image|max:2048',
            'favorit' => 'boolean'
        ]);

        if ($request->hasFile('gambar_menu')) {
            $validated['gambar_menu'] = $request->file('gambar_menu')->store('menus', 'public');
        }
        
        Menu::create($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return Inertia::render('Admin/Menu/Edit', [
            'menu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori' => 'required|in:coffee,non-coffee,makanan,camilan',
            'harga_menu' => 'required|numeric|min:0',
            'deskripsi_menu' => 'required|string',
            'gambar_menu' => 'nullable|image|max:2048', // Tetap validasi
            'favorit' => 'boolean'
        ]);

        // ==========================================
        // PERBAIKAN LOGIKA ADA DI SINI
        // ==========================================
        if ($request->hasFile('gambar_menu')) {
            // 1. Jika ada file baru, hapus yang lama dan simpan yang baru
            if ($menu->gambar_menu) {
                Storage::disk('public')->delete($menu->gambar_menu);
            }
            $validated['gambar_menu'] = $request->file('gambar_menu')->store('menus', 'public');
        } else {
            // 2. Jika TIDAK ada file baru, hapus 'gambar_menu' dari array $validated
            //    agar tidak menimpa data di database dengan null.
            unset($validated['gambar_menu']);
        }
        // ==========================================
        
        $menu->update($validated); // Sekarang aman untuk di-update

        return redirect()->route('admin.dashboard')
            ->with('success', 'Menu berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        if ($menu->gambar_menu) {
            Storage::disk('public')->delete($menu->gambar_menu);
        }
        
        $menu->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Toggle favorite status
     */
    public function toggleFavorite(Menu $menu)
    {
        // Jika sedang mengaktifkan favorite (dari false ke true)
        if (!$menu->favorit) {
            $favoritesCount = Menu::where('favorit', true)->count();
            
            if ($favoritesCount >= 4) {
                return back()->withErrors([
                    'limit' => 'Maksimal 4 menu favorite. Nonaktifkan menu favorite lain terlebih dahulu.'
                ]);
            }
        }

        $menu->favorit = !$menu->favorit; 
        $menu->save();

        return back()->with('success', 'Status favorit berhasil diubah!');
    }
}