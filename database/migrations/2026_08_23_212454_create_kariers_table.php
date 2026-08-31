<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kariers', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->longText('deskripsi');
            $table->longText('kualifikasi');
            $table->string('lokasi');
            $table->string('status')->default('Buka');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kariers');
    }
};