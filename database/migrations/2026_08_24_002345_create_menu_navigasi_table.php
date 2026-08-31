<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('menu_navigasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('link');
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_navigasi');
    }
};