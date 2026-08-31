<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aset_tanah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->decimal('luas_hektar', 10, 2);
            $table->string('peruntukan')->nullable();
            $table->string('skema')->nullable();
            $table->string('status')->default('Tersedia');
            $table->string('gambar')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->longText('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aset_tanah');
    }
};