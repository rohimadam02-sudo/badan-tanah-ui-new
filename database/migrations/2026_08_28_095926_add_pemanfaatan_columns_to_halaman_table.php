<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('halaman', function (Blueprint $table) {
            if (!Schema::hasColumn('halaman', 'skema_pemanfaatan')) {
                $table->json('skema_pemanfaatan')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('halaman', 'bentuk_kerjasama')) {
                $table->json('bentuk_kerjasama')->nullable()->after('skema_pemanfaatan');
            }
            if (!Schema::hasColumn('halaman', 'prosedur_tahapan')) {
                $table->json('prosedur_tahapan')->nullable()->after('bentuk_kerjasama');
            }
            if (!Schema::hasColumn('halaman', 'persyaratan')) {
                $table->json('persyaratan')->nullable()->after('prosedur_tahapan');
            }
            if (!Schema::hasColumn('halaman', 'dokumen_pendukung')) {
                $table->json('dokumen_pendukung')->nullable()->after('persyaratan');
            }
            if (!Schema::hasColumn('halaman', 'faq_pemanfaatan')) {
                $table->json('faq_pemanfaatan')->nullable()->after('dokumen_pendukung');
            }
        });
    }

    public function down(): void
    {
        Schema::table('halaman', function (Blueprint $table) {
            $columns = ['skema_pemanfaatan', 'bentuk_kerjasama', 'prosedur_tahapan', 'persyaratan', 'dokumen_pendukung', 'faq_pemanfaatan'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('halaman', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};