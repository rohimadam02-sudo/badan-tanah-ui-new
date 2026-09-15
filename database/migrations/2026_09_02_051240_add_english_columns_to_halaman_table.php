<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('halaman', function (Blueprint $table) {
            $table->string('judul_en')->nullable()->after('judul');
            $table->longText('isi_en')->nullable()->after('isi');
            $table->string('visi_en')->nullable()->after('visi');
            $table->string('misi_en')->nullable()->after('misi');
            $table->string('struktur_organisasi_en')->nullable()->after('struktur_organisasi');
            $table->string('dasar_hukum_en')->nullable()->after('dasar_hukum');
            $table->string('meta_title_en')->nullable()->after('meta_title');
            $table->text('meta_description_en')->nullable()->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('halaman', function (Blueprint $table) {
            $table->dropColumn([
                'judul_en', 'isi_en', 'visi_en', 'misi_en',
                'struktur_organisasi_en', 'dasar_hukum_en',
                'meta_title_en', 'meta_description_en'
            ]);
        });
    }
};