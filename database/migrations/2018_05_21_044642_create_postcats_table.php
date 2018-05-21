<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostcatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postcats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent');
            $table->string('type');
            $table->string('name');
            $table->string('slug');
            $table->string('image');
            $table->integer('catorder');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postcats');
    }
}
