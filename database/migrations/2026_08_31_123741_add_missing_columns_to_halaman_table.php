<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('halaman', function (Blueprint $table) {
            // Tambahkan kolom visi, misi, struktur_organisasi, dasar_hukum
            if (!Schema::hasColumn('halaman', 'visi')) {
                $table->text('visi')->nullable()->after('isi');
            }
            if (!Schema::hasColumn('halaman', 'misi')) {
                $table->text('misi')->nullable()->after('visi');
            }
            if (!Schema::hasColumn('halaman', 'struktur_organisasi')) {
                $table->text('struktur_organisasi')->nullable()->after('misi');
            }
            if (!Schema::hasColumn('halaman', 'dasar_hukum')) {
                $table->text('dasar_hukum')->nullable()->after('struktur_organisasi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('halaman', function (Blueprint $table) {
            $columns = ['visi', 'misi', 'struktur_organisasi', 'dasar_hukum'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('halaman', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};