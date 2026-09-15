<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_websites', function (Blueprint $table) {
            $table->string('nama_website')->nullable()->after('warna_sekunder');
            $table->text('deskripsi_website')->nullable()->after('nama_website');
            $table->string('logo')->nullable()->after('deskripsi_website');
            $table->string('google_analytics')->nullable()->after('logo');
            $table->string('kimi_api_key')->nullable()->after('google_analytics');
            $table->boolean('qr_enabled')->default(false)->after('kimi_api_key');
            $table->boolean('maintenance_mode')->default(false)->after('qr_enabled');
            $table->string('meta_title_default')->nullable()->after('maintenance_mode');
            $table->text('meta_description_default')->nullable()->after('meta_title_default');
            $table->text('keywords')->nullable()->after('meta_description_default');
            $table->string('timezone')->default('Asia/Jakarta')->after('keywords');
            $table->string('bahasa')->default('id')->after('timezone');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_websites', function (Blueprint $table) {
            $table->dropColumn([
                'nama_website',
                'deskripsi_website',
                'logo',
                'google_analytics',
                'kimi_api_key',
                'qr_enabled',
                'maintenance_mode',
                'meta_title_default',
                'meta_description_default',
                'keywords',
                'timezone',
                'bahasa',
            ]);
        });
    }
};