<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\MenuController;  // Backend CRUD
use App\Http\Controllers\EventController; // Backend CRUD
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ============================================
// PUBLIC ROUTES
// ============================================

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/menu', function () {
    $menus = [
        // Data dummy publik tetap aman
        'makanan' => [
            ['id' => 1, 'name' => 'Nasi Goreng Spesial', 'price' => 'Rp 28.000', 'description' => 'Nasi goreng dengan campuran ayam, telur, dan sayuran.', 'image' => '/images/makanan/nasi-goreng.jpg', 'category' => 'Makanan', 'tags' => ['Nasi']],
            ['id' => 2, 'name' => 'Mie Goreng Seafood', 'price' => 'Rp 32.000', 'description' => 'Mie goreng dengan udang, cumi, dan bakso ikan.', 'image' => '/images/makanan/mie-goreng.jpg', 'category' => 'Makanan', 'tags' => ['Mie']],
            // ... lainnya ...
        ],
        'minuman' => [
            ['id' => 6, 'name' => 'Cappuccino', 'price' => 'Rp 25.000', 'description' => 'Kopi susu klasik dengan foam lembut.', 'image' => '/images/minuman/cappuccino.jpg', 'category' => 'Minuman', 'tags' => ['Kopi']],
            ['id' => 7, 'name' => 'Latte', 'price' => 'Rp 25.000', 'description' => 'Espresso dengan susu steamed.', 'image' => '/images/minuman/latte.jpg', 'category' => 'Minuman', 'tags' => ['Kopi']],
            // ... lainnya ...
        ]
    ];

    return Inertia::render('HalamanMenu', [
        'menus' => $menus
    ]);
})->name('menu.index');

// ============================================
// ADMIN ROUTES
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

        // ==========================================
        // MENU MANAGEMENT (Admin Panel)
        // ==========================================
        Route::prefix('menu')->name('menu.')->group(function () {
            Route::get('/', [AdminMenuController::class, 'index'])->name('index');
            Route::get('/create', [AdminMenuController::class, 'create'])->name('create');
            Route::post('/', [AdminMenuController::class, 'store'])->name('store');
            Route::get('/{menu}/edit', [AdminMenuController::class, 'edit'])->name('edit');
            Route::put('/{menu}', [AdminMenuController::class, 'update'])->name('update');
            Route::delete('/{menu}', [AdminMenuController::class, 'destroy'])->name('destroy');
            Route::post('/{menu}/toggle-favorite', [AdminMenuController::class, 'toggleFavorite'])->name('toggle-favorite');
        });

        // ==========================================
        // EVENT MANAGEMENT (Admin Panel)
        // ==========================================
        Route::prefix('event')->name('event.')->group(function () {
            Route::get('/', [AdminEventController::class, 'index'])->name('index');
            Route::get('/create', [AdminEventController::class, 'create'])->name('create');
            Route::post('/', [AdminEventController::class, 'store'])->name('store');
            Route::get('/{event}/edit', [AdminEventController::class, 'edit'])->name('edit');
            Route::put('/{event}', [AdminEventController::class, 'update'])->name('update'); // PUT untuk upload file
            Route::delete('/{event}', [AdminEventController::class, 'destroy'])->name('destroy');
        });
    });
});

// ============================================
// BACKEND CRUD ROUTES (Inertia Storage)
// ============================================
// Opsional untuk Admin akses langsung CRUD Menu & Event
Route::middleware('auth:admin')->group(function () {
    Route::resource('backend/menu', MenuController::class);
    Route::resource('backend/event', EventController::class);
});
