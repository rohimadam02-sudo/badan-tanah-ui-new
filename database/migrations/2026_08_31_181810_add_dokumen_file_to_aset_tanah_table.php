<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aset_tanah', function (Blueprint $table) {
            // Tambahkan kolom untuk menyimpan path file
            if (!Schema::hasColumn('aset_tanah', 'dokumen_files')) {
                $table->json('dokumen_files')->nullable()->after('dokumen');
            }
        });
    }

    public function down(): void
    {
        Schema::table('aset_tanah', function (Blueprint $table) {
            $table->dropColumn('dokumen_files');
        });
    }
};