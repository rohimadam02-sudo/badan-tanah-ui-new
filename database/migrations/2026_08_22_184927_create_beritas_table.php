<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('ringkasan');
            $table->longText('konten');
            $table->string('kategori');
            $table->string('penulis');
            $table->unsignedBigInteger('views')->default(0);
            $table->string('status')->default('Draft');
            $table->string('gambar')->nullable();
            $table->timestamp('tanggal_publikasi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berita');
    }
};