<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminLoginController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Menampilkan halaman login admin
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    // Menangani proses login admin
    Route::post('/login', [AdminLoginController::class, 'login']);
    // Rute dashboard admin (setelah login berhasil)
    Route::middleware('auth:admin')->get('/dashboard', function () { // Ganti 'auth:admin' jika Anda menggunakan guard berbeda
        return Inertia::render('Admin/Dashboard'); // Contoh halaman dashboard admin
    })->name('dashboard');
    // Menangani proses logout admin
    Route::middleware('auth:admin')->post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});


Route::get('/menu', function () {
    // Di sini Anda perlu mengambil data menu dari database atau sumber lain
    // Untuk contoh ini, kita gunakan data statis
    $menus = [
        'makanan' => [
            ['id' => 1, 'name' => 'Nasi Goreng Spesial', 'price' => 'Rp 28.000', 'description' => 'Nasi goreng dengan campuran ayam, telur, dan sayuran.', 'image' => '/images/makanan/nasi-goreng.jpg', 'category' => 'Makanan', 'tags' => ['Nasi']],
            ['id' => 2, 'name' => 'Mie Goreng Seafood', 'price' => 'Rp 32.000', 'description' => 'Mie goreng dengan udang, cumi, dan bakso ikan.', 'image' => '/images/makanan/mie-goreng.jpg', 'category' => 'Makanan', 'tags' => ['Mie']],
            ['id' => 3, 'name' => 'Spaghetti Carbonara', 'price' => 'Rp 35.000', 'description' => 'Spaghetti dengan saus krim, smoked beef, dan keju parmesan.', 'image' => '/images/makanan/carbonara.jpg', 'category' => 'Makanan', 'tags' => ['Pasta']],
            ['id' => 4, 'name' => 'Chicken Katsu Curry', 'price' => 'Rp 38.000', 'description' => 'Ayam katsu renyah disajikan dengan nasi dan saus kari Jepang.', 'image' => '/images/makanan/katsu-curry.jpg', 'category' => 'Makanan', 'tags' => ['Nasi', 'Ayam']],
            ['id' => 5, 'name' => 'Kentang Goreng Keju', 'price' => 'Rp 22.000', 'description' => 'Kentang goreng renyah dengan lelehan keju cheddar.', 'image' => '/images/makanan/kentang-keju.jpg', 'category' => 'Makanan', 'tags' => ['Snack']],
        ],
        'minuman' => [
            // Kopi
            ['id' => 6, 'name' => 'Cappuccino', 'price' => 'Rp 25.000', 'description' => 'Kopi susu klasik dengan foam lembut.', 'image' => '/images/minuman/cappuccino.jpg', 'category' => 'Minuman', 'tags' => ['Kopi']],
            ['id' => 7, 'name' => 'Latte', 'price' => 'Rp 25.000', 'description' => 'Espresso dengan susu steamed.', 'image' => '/images/minuman/latte.jpg', 'category' => 'Minuman', 'tags' => ['Kopi']],
            ['id' => 8, 'name' => 'Espresso', 'price' => 'Rp 18.000', 'description' => 'Ekstraksi kopi murni.', 'image' => '/images/minuman/espresso.jpg', 'category' => 'Minuman', 'tags' => ['Kopi']],
            ['id' => 9, 'name' => 'Cold Brew', 'price' => 'Rp 30.000', 'description' => 'Kopi seduh dingin, rendah asam.', 'image' => '/images/minuman/cold-brew.jpg', 'category' => 'Minuman', 'tags' => ['Kopi']],
            ['id' => 10, 'name' => 'Americano', 'price' => 'Rp 22.000', 'description' => 'Espresso dengan tambahan air panas.', 'image' => '/images/minuman/americano.jpg', 'category' => 'Minuman', 'tags' => ['Kopi']],
            // Non-Kopi
            ['id' => 11, 'name' => 'Matcha Latte', 'price' => 'Rp 28.000', 'description' => 'Bubuk matcha berkualitas dengan susu.', 'image' => '/images/minuman/matcha-latte.jpg', 'category' => 'Minuman', 'tags' => ['Non-Kopi', 'Teh']],
            ['id' => 12, 'name' => 'Chocolate Drink', 'price' => 'Rp 26.000', 'description' => 'Minuman coklat klasik, bisa panas atau dingin.', 'image' => '/images/minuman/chocolate.jpg', 'category' => 'Minuman', 'tags' => ['Non-Kopi', 'Coklat']],
            ['id' => 13, 'name' => 'Lemon Tea', 'price' => 'Rp 20.000', 'description' => 'Teh dengan perasan lemon segar.', 'image' => '/images/minuman/lemon-tea.jpg', 'category' => 'Minuman', 'tags' => ['Non-Kopi', 'Teh']],
             ['id' => 14, 'name' => 'Strawberry Smoothie', 'price' => 'Rp 30.000', 'description' => 'Smoothie segar dari buah stroberi asli.', 'image' => '/images/minuman/strawberry-smoothie.jpg', 'category' => 'Minuman', 'tags' => ['Non-Kopi', 'Buah']],
        ]
    ];

    return Inertia::render('HalamanMenu', [
        'menus' => $menus // Kirim data menu ke komponen Vue
    ]);
})->name('menu.index');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
