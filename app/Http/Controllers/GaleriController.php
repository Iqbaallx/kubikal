<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    // Simpan data galeri
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        // Simpan gambar ke storage/app/public/galeri
        $path = $request->file('gambar')->store('galeri', 'public');

        // Simpan ke database
        Galeri::create([
            'gambar' => $path,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Galeri berhasil ditambahkan',
            'data' => $path
        ], 201);
    }

    // Update status aktif/nonaktif
    public function updateStatus($id, Request $request)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $galeri->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Status berhasil diupdate',
            'data' => $galeri
        ]);
    }

    // Hapus galeri (termauk hapus gambar di storage)
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        // Hapus file gambar
        Storage::disk('public')->delete($galeri->gambar);

        $galeri->delete();

        return response()->json([
            'message' => 'Galeri berhasil dihapus'
        ]);
    }

    // Ambil semua galeri
    public function index()
    {
        return response()->json(Galeri::all());
    }
}
