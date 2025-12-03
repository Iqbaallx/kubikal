<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\EventController as AdminEventController;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\EventController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ============================================
// PUBLIC ROUTES
// ============================================

// Home
Route::get('/', [MenuController::class, 'index'])->name('home');

// Menu page
Route::get('/menu', [MenuController::class, 'showMenu'])->name('menu.index');

// Gallery page
Route::get('/gallery', [MenuController::class, 'gallery'])->name('gallery.index');


// ============================================
// ADMIN ROUTES
// ============================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Login Admin
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });

    // Setelah Login
    Route::middleware('auth:admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // MENU MANAGEMENT
        Route::prefix('menu')->name('menu.')->group(function () {
            Route::post('/', [AdminMenuController::class, 'store'])->name('store');
            Route::put('/{menu}', [AdminMenuController::class, 'update'])->name('update');
            Route::post('/{menu}', [AdminMenuController::class, 'update']); // Support POST with _method for file uploads
            Route::delete('/{menu}', [AdminMenuController::class, 'destroy'])->name('destroy');
            Route::post('/{menu}/toggle-favorite', [AdminMenuController::class, 'toggleFavorite'])->name('toggle-favorite');
        });

        // EVENT MANAGEMENT
        Route::prefix('event')->name('event.')->group(function () {
            Route::post('/', [AdminEventController::class, 'store'])->name('store');
            Route::put('/{event}', [AdminEventController::class, 'update'])->name('update');
            Route::post('/{event}', [AdminEventController::class, 'update']); // Support POST with _method for file uploads
            Route::delete('/{event}', [AdminEventController::class, 'destroy'])->name('destroy');
        });

        // GALERI MANAGEMENT
        Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
        Route::post('/galeri/{id}/toggle-favorite', [GaleriController::class, 'toggleFavorite'])->name('galeri.toggle-favorite');
        Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');
    });
});


// ============================================
// BACKEND CRUD ROUTES (optional)
// ============================================
Route::middleware('auth:admin')->group(function () {
    Route::resource('backend/menu', MenuController::class)->except(['index', 'show']);
    Route::resource('backend/event', EventController::class)->except(['index', 'show']);
});

// Auth
require __DIR__.'/auth.php';
