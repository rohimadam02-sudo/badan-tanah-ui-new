<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan kolom SEO ke tabel berita
        Schema::table('berita', function (Blueprint $table) {
            if (!Schema::hasColumn('berita', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('berita', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('berita', 'qr_code')) {
                $table->text('qr_code')->nullable()->after('meta_description');
            }
        });

        // Tambahkan kolom SEO ke tabel aset_tanah
        Schema::table('aset_tanah', function (Blueprint $table) {
            if (!Schema::hasColumn('aset_tanah', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('aset_tanah', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
            if (!Schema::hasColumn('aset_tanah', 'qr_code')) {
                $table->text('qr_code')->nullable()->after('meta_description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'qr_code']);
        });

        Schema::table('aset_tanah', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'qr_code']);
        });
    }
};