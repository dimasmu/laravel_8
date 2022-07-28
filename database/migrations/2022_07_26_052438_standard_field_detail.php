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
        Schema::create('standard_field_detail', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->boolean('is_status')->nullable()->default(false);
            $table->unsignedBigInteger('group');
            $table->foreign('group')->references('id')->on('standard_field')
            ->onDelete('cascade');
            $table->integer('created_by')->nullable()->default(0);
            $table->integer('updated_by')->nullable()->default(0);
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
        Schema::dropIfExists('standard_field_detail');
    }
};
