<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return Inertia::render('Menu/Index', ['menus' => $menus]);
    }

    public function create()
    {
        return Inertia::render('Menu/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi_menu' => 'required|string',
            'harga_menu' => 'required|numeric',
            'kategori' => 'required|in:coffee,non-coffee,makanan,camilan',
            'favorit' => 'required|in:Y,N',
            'gambar_menu' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->hasFile('gambar_menu')
            ? $request->file('gambar_menu')->store('menu', 'public')
            : null;

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'deskripsi_menu' => $request->deskripsi_menu,
            'harga_menu' => $request->harga_menu,
            'kategori' => $request->kategori,
            'favorit' => $request->favorit,
            'gambar_menu' => $path,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return Inertia::render('Menu/Edit', ['menu' => $menu]);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi_menu' => 'required|string',
            'harga_menu' => 'required|numeric',
            'kategori' => 'required|in:coffee,non-coffee,makanan,camilan',
            'favorit' => 'required|in:Y,N',
            'gambar_menu' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar_menu')) {
            if ($menu->gambar_menu && Storage::disk('public')->exists($menu->gambar_menu)) {
                Storage::disk('public')->delete($menu->gambar_menu);
            }
            $menu->gambar_menu = $request->file('gambar_menu')->store('menu', 'public');
        }

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'deskripsi_menu' => $request->deskripsi_menu,
            'harga_menu' => $request->harga_menu,
            'kategori' => $request->kategori,
            'favorit' => $request->favorit,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->gambar_menu && Storage::disk('public')->exists($menu->gambar_menu)) {
            Storage::disk('public')->delete($menu->gambar_menu);
        }

        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}
