<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash; // <-- TAMBAHKAN INI
use App\Models\Admin; // <-- TAMBAHKAN INI
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

        // ======== KODE DEBUG SEMENTARA (MULAI) ========
        // Kita periksa secara manual apa yang terjadi

        // 1. Cari admin berdasarkan username
        $admin = Admin::where('username', $request->username)->first();

        // 2. Cek apakah admin-nya ada
        if (!$admin) {
            // Hentikan eksekusi dan tampilkan pesan ini
            dd('DEBUG: User TIDAK DITEMUKAN. Tidak ada user di tabel "admins" dengan username:', $request->username);
        }

        // 3. Cek apakah password-nya cocok
        $passwordCocok = Hash::check($request->password, $admin->password);

        if ($passwordCocok) {
            // Jika password cocok, seharusnya login berhasil.
            // Jika Anda melihat ini tapi login tetap gagal, masalahnya ada di config/auth.php atau Admin.php
            
            // Kita coba login manual
            Auth::guard('admin')->login($admin, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));

            // dd('DEBUG: User DITEMUKAN dan Password COCOK. Login seharusnya berhasil. Cek config/auth.php dan Admin.php (protected $guard).');

        } else {
            // Hentikan eksekusi dan tampilkan pesan ini
            dd('DEBUG: User DITEMUKAN, tapi PASSWORD SALAH.', [
                'Password dari Form (Anda ketik)' => $request->password,
                'Password di Database (Hash)' => $admin->password,
                'Apakah Hash Cocok?' => 'TIDAK',
            ]);
        }
        // ======== KODE DEBUG SEMENTARA (SELESAI) ========


        /*
        // --- Kode Asli (Kita non-aktifkan sementara) ---
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
        */
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
