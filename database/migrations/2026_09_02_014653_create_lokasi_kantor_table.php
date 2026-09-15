<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokasi_kantor', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('icon')->nullable(); // Font Awesome icon
            $table->string('warna')->nullable(); // Warna marker
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_utama')->default(false);
            $table->text('deskripsi')->nullable();
            $table->string('jam_kerja')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi_kantor');
    }
};