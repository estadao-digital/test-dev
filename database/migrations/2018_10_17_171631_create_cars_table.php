<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id')->comment('Identification of car.');
            $table->string('name', 32)->comment('Name of car.');
            $table->string('brand', 32)->comment('Brand of car.');
            $table->string('model', 32)->comment('Model of car.');
            $table->string('year', 4)->comment('Year of car.');
            $table->dateTime('created')->comment('Time the row is created.');
            $table->dateTime('updated')->nullable()->comment('Time this row is updated.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
