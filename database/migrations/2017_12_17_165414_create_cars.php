<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('model');
            $table->string('image_location');
            $table->char('year', 4);
            $table->enum('excluded', ['0','1'])->default('0');
            $table->integer('manufacturer_id')->unsigned();
            $table->timestamps();

            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
