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
        Schema::create('movie', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('thumbnail',255)->nullable()->default(null);
            $table->json('category')->nullable()->default(null);
            $table->timestamp('release')->nullable()->default(null);
            $table->timestamp('aired_from')->nullable()->default(null);
            $table->timestamp('aired_to')->nullable()->default(null);
            $table->integer('duration')->nullable()->default(null);
            $table->integer('status')->nullable()->default(null);
            $table->boolean('is_status')->nullable()->default(null);
            $table->integer('created_by')->nullable()->default(0);
            $table->integer('updated_by')->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie');
    }
};
