<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\MenuController;  // Controller Publik
use App\Http\Controllers\EventController; // Controller Publik
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ============================================
// PUBLIC ROUTES (SUDAH DIUBAH)
// ============================================

// Mengarahkan rute '/' ke MenuController@index (untuk Home.vue)
Route::get('/', [MenuController::class, 'index'])->name('home');

// Mengarahkan rute '/menu' ke MenuController@showMenu (untuk HalamanMenu.vue)
Route::get('/menu', [MenuController::class, 'showMenu'])->name('menu.index');


// ============================================
// ADMIN ROUTES (TETAP SAMA)
// ============================================

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest Routes (Login)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });

    // Protected Admin Routes
    Route::middleware('auth:admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Logout
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // MENU MANAGEMENT (Admin Panel)
        Route::prefix('menu')->name('menu.')->group(function () {
            // Hapus rute duplikat dan yang tidak terpakai
            Route::post('/', [AdminMenuController::class, 'store'])->name('store');
            Route::put('/{menu}', [AdminMenuController::class, 'update'])->name('update');
            Route::delete('/{menu}', [AdminMenuController::class, 'destroy'])->name('destroy');
            Route::post('/{menu}/toggle-favorite', [AdminMenuController::class, 'toggleFavorite'])->name('toggle-favorite');
        });

        // EVENT MANAGEMENT (Admin Panel)
        Route::prefix('event')->name('event.')->group(function () {
            Route::post('/', [AdminEventController::class, 'store'])->name('store');
            Route::put('/{event}', [AdminEventController::class, 'update'])->name('update');
            Route::delete('/{event}', [AdminEventController::class, 'destroy'])->name('destroy');
        });
    });
});

// ============================================
// BACKEND CRUD ROUTES (TETAP SAMA)
// ============================================
Route::middleware('auth:admin')->group(function () {
    Route::resource('backend/menu', MenuController::class)->except(['index', 'show']);
    Route::resource('backend/event', EventController::class)->except(['index', 'show']);
});

// Tambahkan rute auth bawaan jika belum ada
require __DIR__.'/auth.php';