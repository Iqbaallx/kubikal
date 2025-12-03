# Kubikal Space - Setup Guide

Panduan lengkap untuk setup project Kubikal Space di komputer lokal.

## Prerequisites

Pastikan sudah terinstall:
- **PHP 8.1+** ([Download](https://www.php.net/downloads))
- **Composer** ([Download](https://getcomposer.org/download/))
- **Node.js 16+** dan npm ([Download](https://nodejs.org/))
- **Database**: MySQL, MariaDB, PostgreSQL, atau SQLite

## Langkah-langkah Setup

### 1. Clone Repository

```bash
git clone <repository-url>
cd kubikal
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Setup Environment

```bash
# Copy file environment example
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan database kamu:

**Untuk MySQL/MariaDB:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kubikal
DB_USERNAME=root
DB_PASSWORD=
```

**Untuk SQLite (default):**
```env
DB_CONNECTION=sqlite
# Buat file database kosong
touch database/database.sqlite
```

### 5. Jalankan Migration & Seeder

```bash
# Jalankan migration untuk membuat tabel
php artisan migrate

# Jalankan seeder untuk membuat admin user
php artisan db:seed
```

Setelah seeder berjalan, kamu akan mendapat kredensial admin:
- **Email**: `admin@kubikal.com`
- **Password**: `admin123`

> **Penting**: Ganti password setelah login pertama kali!

### 6. Buat Storage Link

```bash
# Link storage folder agar gambar bisa diakses
php artisan storage:link
```

Jika muncul error "symlink already exists", jalankan:
```bash
rm public/storage
php artisan storage:link
```

### 7. Build Assets

**Development mode (untuk coding):**
```bash
npm run dev
```

**Production mode (untuk deployment):**
```bash
npm run build
```

### 8. Jalankan Server

```bash
php artisan serve
```

Website akan berjalan di: `http://localhost:8000`

## Login Admin

1. Buka browser dan akses: `http://localhost:8000/admin/login`
2. Login dengan kredensial:
   - Email: `admin@kubikal.com`
   - Password: `admin123`
3. Setelah login, kamu bisa mengelola Menu, Event, dan Gallery

## Testing Fungsionalitas

### Test Upload Gambar
1. Login ke admin panel
2. Pergi ke "Kelola Menu" → "Tambah Menu Baru"
3. Isi form dan upload gambar
4. Klik simpan
5. ✓ Menu baru harus muncul dengan gambar yang ditampilkan

### Test Edit Data
1. Klik tombol "Edit" pada menu yang sudah ada
2. Ubah nama atau harga
3. Klik simpan
4. ✓ Perubahan harus tersimpan

## Troubleshooting

### Error: "storage link does not exist"
**Solusi:**
```bash
php artisan storage:link
```

### Error: "SQLSTATE[HY000]: General error: 1 no such table"
**Solusi:** Migration belum dijalankan
```bash
php artisan migrate
```

### Error: "No application encryption key has been specified"
**Solusi:**
```bash
php artisan key:generate
```

### Tidak bisa login admin / "Invalid credentials"
**Solusi:** Seeder belum dijalankan atau admin belum dibuat
```bash
php artisan db:seed --class=AdminSeeder
```

### Gambar tidak muncul setelah diupload
**Solusi:** Storage link belum dibuat
```bash
rm public/storage  # hapus jika sudah ada
php artisan storage:link
```

### Permission denied saat upload gambar
**Solusi:** Set permission untuk folder storage
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache

# Windows dengan Git Bash
chmod -R 775 storage bootstrap/cache
```

### CSS/JS tidak muncul atau tidak update
**Solusi:** Clear cache dan rebuild
```bash
npm run build
php artisan optimize:clear
```

### Port 8000 sudah dipakai
**Solusi:** Gunakan port lain
```bash
php artisan serve --port=8001
```

## Reset Database (Fresh Start)

Jika ingin reset database dari awal:

```bash
# Hapus semua data dan jalankan ulang migration + seeder
php artisan migrate:fresh --seed
```

⚠️ **Warning**: Perintah ini akan **menghapus semua data** di database!

## Development Tips

### Menambahkan Admin Baru (Manual)

Jika ingin membuat admin tambahan:

```bash
php artisan tinker
```

Lalu jalankan:
```php
\App\Models\Admin::create([
    'email' => 'admin2@kubikal.com',
    'password' => \Hash::make('password123')
]);
```

### Mengubah Password Admin

Via tinker:
```bash
php artisan tinker
```

```php
$admin = \App\Models\Admin::where('email', 'admin@kubikal.com')->first();
$admin->password = \Hash::make('newpassword123');
$admin->save();
```

## Struktur Folder Penting

```
kubikal/
├── app/
│   ├── Http/Controllers/Admin/    # Admin controllers
│   └── Models/                     # Database models
├── database/
│   ├── migrations/                 # Database migrations
│   └── seeders/                    # Database seeders
├── public/
│   └── storage/                    # Symlink ke storage (created by artisan)
├── resources/
│   ├── js/
│   │   ├── Components/Admin/       # Admin Vue components
│   │   └── Pages/                  # Vue pages
│   └── views/                      # Blade templates
├── routes/
│   └── admin.php                   # Admin routes
└── storage/
    └── app/public/                 # File storage (images, etc)
```

## Bantuan Lebih Lanjut

Jika masih ada masalah:
1. Cek error log di `storage/logs/laravel.log`
2. Pastikan semua langkah di atas sudah dijalankan dengan benar
3. Restart server development (`php artisan serve`)
4. Clear cache: `php artisan optimize:clear`

---

**Selamat coding! 🚀**
