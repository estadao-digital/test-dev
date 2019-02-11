<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarrosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marca_id')->unsigned();
            $table->string('modelo');
            $table->year('ano');

            $table->foreign('marca_id', 'fk_carros_marca_id')
                ->references('id')
                ->on('marcas');
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
