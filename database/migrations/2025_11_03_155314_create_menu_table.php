<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id_menu');
            $table->string('nama_menu', 255);
            $table->text('deskripsi_menu');
            $table->decimal('harga_menu', 10, 2);
            $table->enum('kategori', ['coffee', 'non-coffee', 'makanan', 'camilan']);
            $table->enum('favorit', ['Y', 'N'])->default('N');
            $table->string('gambar_menu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
