<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('vendor_products', function (Blueprint $table) {
            $table->integer('price')->after('description');
            $table->integer('max_redeemable_points')->after('price');
        });
    }
    
    public function down()
    {
        Schema::table('vendor_products', function (Blueprint $table) {
            $table->dropColumn(['price', 'max_redeemable_points']);
        });
    }
};
