<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return Inertia::render('Event/Index', ['events' => $events]);
    }

    public function create()
    {
        return Inertia::render('Event/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi_event' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'gambar_event' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->hasFile('gambar_event')
            ? $request->file('gambar_event')->store('event', 'public')
            : null;

        Event::create([
            'nama_event' => $request->nama_event,
            'deskripsi_event' => $request->deskripsi_event,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'gambar_event' => $path,
        ]);

        return redirect()->route('event.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return Inertia::render('Event/Edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi_event' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'gambar_event' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar_event')) {
            if ($event->gambar_event && Storage::disk('public')->exists($event->gambar_event)) {
                Storage::disk('public')->delete($event->gambar_event);
            }
            $event->gambar_event = $request->file('gambar_event')->store('event', 'public');
        }

        $event->update([
            'nama_event' => $request->nama_event,
            'deskripsi_event' => $request->deskripsi_event,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
        ]);

        return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        if ($event->gambar_event && Storage::disk('public')->exists($event->gambar_event)) {
            Storage::disk('public')->delete($event->gambar_event);
        }
        $event->delete();
        return redirect()->route('event.index')->with('success', 'Event berhasil dihapus.');
    }
}
