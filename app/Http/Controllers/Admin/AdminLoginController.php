<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse; // Pastikan ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response; // Pastikan ini di-import

class AdminLoginController extends Controller
{
    /**
     * Menampilkan formulir login admin.
     *
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function showLoginForm(): Response|RedirectResponse
    {
        // Jika admin sudah login, redirect ke dashboard admin
        if (Auth::guard('admin')->check()) { // Sesuaikan nama guard jika berbeda
            return redirect()->route('admin.dashboard'); // Ini adalah RedirectResponse
        }

        return Inertia::render('Admin/Login'); // Ini adalah Inertia\Response
    }

    /**
     * Menangani upaya login admin.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string', // Pastikan ini 'username'
            'password' => 'required|string',
        ]);

        // Sesuaikan field yang digunakan untuk login
        // Sesuaikan juga nama guard ('admin')
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika login gagal
        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')], // Pesan error standar Laravel
        ]);
    }

    /**
     * Menangani logout admin.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout(); // Sesuaikan nama guard

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login'); // Redirect kembali ke halaman login admin
    }
}