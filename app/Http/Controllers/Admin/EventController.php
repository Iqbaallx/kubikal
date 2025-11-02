<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EventController extends Controller
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
        return Inertia::render('Admin/Event/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // TODO: Simpan ke database
        // if ($request->hasFile('gambar')) {
        //     $validated['gambar_path'] = $request->file('gambar')->store('events', 'public');
        // }
        // Event::create($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // TODO: Ambil dari database
        // $event = Event::findOrFail($id);
        
        $event = [
            'id' => $id,
            'nama' => 'Diskon Kemerdekaan',
            'tanggal' => '2024-08-17',
            'waktu' => '10:00',
            'deskripsi' => 'Nikmati diskon spesial untuk merayakan Hari Kemerdekaan! Dapatkan potongan harga 17% untuk semua minuman.',
            'gambar_url' => null
        ];

        return Inertia::render('Admin/Event/Edit', [
            'event' => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        // TODO: Update database
        // $event = Event::findOrFail($id);
        // 
        // if ($request->hasFile('gambar')) {
        //     // Hapus gambar lama jika ada
        //     if ($event->gambar_path) {
        //         Storage::disk('public')->delete($event->gambar_path);
        //     }
        //     $validated['gambar_path'] = $request->file('gambar')->store('events', 'public');
        // }
        // 
        // $event->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Event berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // TODO: Hapus dari database
        // $event = Event::findOrFail($id);
        // 
        // // Hapus gambar jika ada
        // if ($event->gambar_path) {
        //     Storage::disk('public')->delete($event->gambar_path);
        // }
        // 
        // $event->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Event berhasil dihapus!');
    }
}