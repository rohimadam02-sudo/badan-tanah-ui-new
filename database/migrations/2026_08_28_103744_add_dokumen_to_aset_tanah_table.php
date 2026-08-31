<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aset_tanah', function (Blueprint $table) {
            if (!Schema::hasColumn('aset_tanah', 'dokumen')) {
                $table->json('dokumen')->nullable()->after('deskripsi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('aset_tanah', function (Blueprint $table) {
            $table->dropColumn('dokumen');
        });
    }
};