<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->string('judul_en')->nullable()->after('judul');
            $table->text('ringkasan_en')->nullable()->after('ringkasan');
            $table->longText('konten_en')->nullable()->after('konten');
            $table->string('meta_title_en')->nullable()->after('meta_title');
            $table->text('meta_description_en')->nullable()->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->dropColumn([
                'judul_en', 'ringkasan_en', 'konten_en',
                'meta_title_en', 'meta_description_en'
            ]);
        });
    }
};