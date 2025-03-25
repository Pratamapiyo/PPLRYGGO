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
        Schema::table('vendor_transactions', function (Blueprint $table) {
            $table->integer('final_price')->default(0)->after('points_used'); // Ensure this column is correctly defined
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_transactions', function (Blueprint $table) {
            $table->dropColumn('final_price'); // Remove final_price column
        });
    }
};
