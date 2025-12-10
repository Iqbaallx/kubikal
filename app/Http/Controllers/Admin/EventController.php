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
        // Cek jumlah event aktif (tanggal_selesai >= hari ini)
        $activeEventsCount = Event::where('tanggal_selesai', '>=', now()->toDateString())->count();
        
        if ($activeEventsCount >= 3) {
            return back()->withErrors([
                'limit' => 'Maksimal 3 event aktif. Tunggu event lain selesai atau hapus event yang tidak diperlukan.'
            ]);
        }

        // Validasi ini sudah benar dari sebelumnya
        $validated = $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi_event' => 'required|string',
            'tanggal' => 'nullable|date',
            'waktu' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
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
            'tanggal' => 'nullable|date',
            'waktu' => 'nullable|date_format:H:i,H:i:s',
            'waktu_selesai' => 'nullable|date_format:H:i,H:i:s',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
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