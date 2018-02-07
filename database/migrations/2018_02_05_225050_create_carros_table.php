<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrosTable extends Migration
{
    public function up()
    {
        Schema::create('carros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ano');
            $table->string('modelo');
            $table->string('marca_id')->unsigned();
            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carros');
    }
}
