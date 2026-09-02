<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_websites', function (Blueprint $table) {
            if (!Schema::hasColumn('pengaturan_websites', 'lat_kantor')) {
                $table->decimal('lat_kantor', 10, 7)->nullable()->after('bahasa');
            }
            if (!Schema::hasColumn('pengaturan_websites', 'lng_kantor')) {
                $table->decimal('lng_kantor', 10, 7)->nullable()->after('lat_kantor');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_websites', function (Blueprint $table) {
            $table->dropColumn(['lat_kantor', 'lng_kantor']);
        });
    }
};