<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelosTable extends Migration
{
    /**
     * Migration para criação da tabela Carros.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marca')->unsigned();
            $table->string('modelo');
        });
    }

    /**
     * Reverte a migração
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('carros');
    }
}
