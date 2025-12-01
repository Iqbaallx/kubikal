<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('galeri', function (Blueprint $table) {
        $table->id('id_galeri');
        $table->string('gambar');
        $table->string('tipe'); // <--- TAMBAHKAN INI (PENTING)
        $table->boolean('is_favorite')->default(false); // Pastikan ini juga ada
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};