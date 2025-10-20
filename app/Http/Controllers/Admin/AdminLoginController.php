<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;

class AdminLoginController extends Controller
{
    /**
     * Menampilkan formulir login admin.
     */
    public function showLoginForm()
    {
        // Jika admin sudah login, redirect ke dashboard admin
        if (Auth::guard('admin')->check()) { // Sesuaikan nama guard jika berbeda
            return redirect()->route('admin.dashboard');
        }
        return Inertia::render('Admin/Login'); // Nama file Vue yang akan kita buat
    }

    /**
     * Menangani upaya login admin.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string', // atau 'email' jika menggunakan email
            'password' => 'required|string',
        ]);

        // Sesuaikan field yang digunakan untuk login (misal 'email' bukan 'username')
        // Sesuaikan juga nama guard ('admin') jika berbeda
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