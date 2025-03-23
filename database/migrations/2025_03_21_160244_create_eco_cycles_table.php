<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoCyclesTable extends Migration
{
    public function up()
    {
        Schema::create('eco_cycles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Pemohon (client)
            $table->unsignedBigInteger('vendor_id')->nullable(); // Vendor yang memproses (bisa null jika belum diproses)
            $table->string('kategori_sampah');
            $table->decimal('berat', 10, 2);
            $table->string('alamat');
            $table->text('deskripsi')->nullable();
            $table->string('foto'); // Menyimpan path file foto
            $table->string('status'); // Contoh: pending, processing, approved, declined
            $table->timestamps();

            // Foreign Key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('eco_cycles');
    }
}
