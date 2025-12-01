<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GaleriController extends Controller
{
    // Fungsi ini dipanggil dari Route Home (web.php)
    // Pastikan di web.php route '/' mengarah ke controller yang benar atau update method ini
    public function landing()
    {
        // Ambil 4 gambar tipe 'standard'
        // Prioritas: yang difavoritkan, lalu yang terbaru
        $galeriHome = Galeri::where('tipe', 'standard')
            ->orderBy('is_favorite', 'desc') 
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Anda bisa menggabungkan ini dengan data Menu/Event jika Controller Home terpisah.
        // Jika Home punya controller sendiri (misal MenuController), copy logika query ini ke sana.
        return Inertia::render('Home', [
            'galeri' => $galeriHome
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'gambar' => 'required|image|max:10240', // Max 10MB
            'is_favorite' => 'boolean'
        ]);

        // Simpan File
        $path = $request->file('gambar')->store('galeri', 'public');

        // Simpan ke Database
        Galeri::create([
            'gambar'      => $path,
            'tipe'        => 'standard', // Default ke standard karena tipe tidak lagi digunakan untuk layout
            'is_favorite' => $request->boolean('is_favorite', false)
        ]);

        return Redirect::back()->with('success', 'Gambar berhasil ditambahkan!');
    }

    public function toggleFavorite($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->is_favorite = !$galeri->is_favorite;
        $galeri->save();

        return Redirect::back()->with('success', 'Status favorit berhasil diubah!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        if ($galeri->gambar) Storage::disk('public')->delete($galeri->gambar);
        $galeri->delete();

        return Redirect::back()->with('success', 'Gambar berhasil dihapus!');
    }
}