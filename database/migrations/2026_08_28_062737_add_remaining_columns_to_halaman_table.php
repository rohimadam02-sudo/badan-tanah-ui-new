<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('halaman', function (Blueprint $table) {
            // Tambahkan kolom yang belum ada
            if (!Schema::hasColumn('halaman', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('foto');
            }
            if (!Schema::hasColumn('halaman', 'slug')) {
                $table->string('slug')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('halaman', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('halaman', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('halaman', function (Blueprint $table) {
            $columns = ['is_active', 'slug', 'meta_title', 'meta_description'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('halaman', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};