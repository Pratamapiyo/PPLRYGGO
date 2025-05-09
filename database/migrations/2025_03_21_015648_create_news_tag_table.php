<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTagTable extends Migration
{
    public function up()
    {
        Schema::create('news_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('tag_id');

            // Composite primary key
            $table->primary(['news_id', 'tag_id']);

            // Foreign key constraints
            $table->foreign('news_id')
                  ->references('id')->on('news')
                  ->onDelete('cascade');
            $table->foreign('tag_id')
                  ->references('id')->on('tags')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('news_tag');
    }
}
