<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aset_tanah', function (Blueprint $table) {
            $table->string('nama_lokasi_en')->nullable()->after('nama_lokasi');
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
            $table->string('peruntukan_en')->nullable()->after('peruntukan');
            $table->string('skema_en')->nullable()->after('skema');
            $table->string('meta_title_en')->nullable()->after('meta_title');
            $table->text('meta_description_en')->nullable()->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('aset_tanah', function (Blueprint $table) {
            $table->dropColumn([
                'nama_lokasi_en', 'deskripsi_en', 'peruntukan_en',
                'skema_en', 'meta_title_en', 'meta_description_en'
            ]);
        });
    }
};