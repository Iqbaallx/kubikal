<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('admin.dashboard', ['tab' => 'event']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.dashboard', ['tab' => 'event']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi ini sudah benar dari sebelumnya
        $validated = $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi_event' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'gambar_event' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar_event')) {
            $validated['gambar_event'] = $request->file('gambar_event')->store('events', 'public');
        }

        Event::create($validated);

        return Redirect::route('admin.dashboard', ['tab' => 'event'])
            ->with('success', 'Event baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return redirect()->route('admin.dashboard', ['tab' => 'event']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Validasi ini sudah benar
        $validated = $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi_event' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i,H:i:s',
            'gambar_event' => 'nullable|image|max:2048',
        ]);

        // ==========================================
        // PERBAIKAN LOGIKA ADA DI SINI
        // ==========================================
        if ($request->hasFile('gambar_event')) {
            // 1. Jika ada file baru, hapus yang lama dan simpan yang baru
            if ($event->gambar_event) {
                Storage::disk('public')->delete($event->gambar_event);
            }
            $validated['gambar_event'] = $request->file('gambar_event')->store('events', 'public');
        } else {
            // 2. Jika TIDAK ada file baru, hapus 'gambar_event' dari array $validated
            unset($validated['gambar_event']);
        }
        // ==========================================

        $event->update($validated); // Aman untuk di-update

        return Redirect::route('admin.dashboard', ['tab' => 'event'])
            ->with('success', 'Event berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->gambar_event) {
            Storage::disk('public')->delete($event->gambar_event);
        }

        $event->delete();

        return Redirect::route('admin.dashboard', ['tab' => 'event'])
            ->with('success', 'Event berhasil dihapus!');
    }
}