<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarcasTable extends Migration
{
    /**
     * Migration para criação da tabela Carros.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('marca');
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
