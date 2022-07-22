<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_movie', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_movie_id');
            $table->foreign('detail_movie_id')->references('id')->on('detail_movie')
            ->onDelete('cascade');
            $table->string('link')->nullable();
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
        Schema::dropIfExists('link_movie');
    }
};
