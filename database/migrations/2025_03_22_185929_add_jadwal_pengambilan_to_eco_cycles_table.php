<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('eco_cycles', function (Blueprint $table) {
            $table->timestamp('jadwal_pengambilan')->nullable()->after('status'); // Tambahkan kolom ini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eco_cycles', function (Blueprint $table) {
            $table->dropColumn('jadwal_pengambilan'); // Hapus kolom ini
        });
    }
};
