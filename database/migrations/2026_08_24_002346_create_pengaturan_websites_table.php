<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaturan_websites', function (Blueprint $table) {
            $table->id();
            $table->string('judul_hero');
            $table->string('subjudul_hero');
            $table->string('tombol_text');
            $table->string('tombol_link');
            $table->string('warna_utama')->default('#0B2A4A');
            $table->string('warna_sekunder')->default('#1D4ED8');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaturan_websites');
    }
};