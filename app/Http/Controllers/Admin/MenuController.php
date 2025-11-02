<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: Ganti dengan query database
        // $menus = Menu::all();
        
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
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Makanan,Minuman',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:2048', // Max 2MB
            'favorit' => 'boolean'
        ]);

        // TODO: Simpan ke database
        // if ($request->hasFile('foto')) {
        //     $validated['foto_path'] = $request->file('foto')->store('menus', 'public');
        // }
        // Menu::create($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // TODO: Ambil data dari database
        // $menu = Menu::findOrFail($id);
        
        $menu = [
            'id' => $id,
            'nama' => 'Espresso',
            'kategori' => 'Minuman',
            'harga' => 25000,
            'deskripsi' => 'Kopi susu murni',
            'favorit' => true,
            'foto_url' => null
        ];

        return Inertia::render('Admin/Menu/Edit', [
            'menu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Makanan,Minuman',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'favorit' => 'boolean'
        ]);

        // TODO: Update database
        // $menu = Menu::findOrFail($id);
        // 
        // if ($request->hasFile('foto')) {
        //     // Hapus foto lama jika ada
        //     if ($menu->foto_path) {
        //         Storage::disk('public')->delete($menu->foto_path);
        //     }
        //     $validated['foto_path'] = $request->file('foto')->store('menus', 'public');
        // }
        // 
        // $menu->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Menu berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // TODO: Hapus dari database
        // $menu = Menu::findOrFail($id);
        // 
        // // Hapus foto jika ada
        // if ($menu->foto_path) {
        //     Storage::disk('public')->delete($menu->foto_path);
        // }
        // 
        // $menu->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Toggle favorite status
     */
    public function toggleFavorite($id)
    {
        // TODO: Update status favorit di database
        // $menu = Menu::findOrFail($id);
        // $menu->favorit = !$menu->favorit;
        // $menu->save();

        return back()->with('success', 'Status favorit berhasil diubah!');
    }
}