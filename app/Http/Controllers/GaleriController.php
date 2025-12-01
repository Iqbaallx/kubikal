<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class GaleriController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|max:5120', // Max 5MB
            'tipe'   => 'required|in:main,small_1,small_2,standard',
        ]);

        // Validasi Slider Max 10
        if ($request->tipe === 'main') {
            if (Galeri::where('tipe', 'main')->count() >= 10) {
                return back()->withErrors(['gambar' => 'Maksimal 10 gambar untuk slider utama.']);
            }
        }

        // Replace gambar kecil jika sudah ada
        if (in_array($request->tipe, ['small_1', 'small_2'])) {
            $existing = Galeri::where('tipe', $request->tipe)->first();
            if ($existing) {
                if ($existing->gambar) Storage::disk('public')->delete($existing->gambar);
                $existing->delete();
            }
        }

        $path = $request->file('gambar')->store('galeri', 'public');

        Galeri::create([
            'gambar' => $path,
            'tipe' => $request->tipe
        ]);

        return Redirect::back()->with('success', 'Gambar berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        if ($galeri->gambar) Storage::disk('public')->delete($galeri->gambar);
        $galeri->delete();

        return Redirect::back()->with('success', 'Gambar berhasil dihapus!');
    }
}