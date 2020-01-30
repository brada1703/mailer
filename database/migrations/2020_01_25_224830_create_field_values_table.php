<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subscriber_id');
            $table->foreign('subscriber_id')->references('id')->on('subscribers')->onDelete('cascade');
            $table->unsignedBigInteger('field_id');
            $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            $table->string('value', 255);
            $table->timestamps();

            $table->unique(['subscriber_id', 'field_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_values');
    }
}
