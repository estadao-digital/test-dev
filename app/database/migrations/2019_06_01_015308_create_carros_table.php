<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carros', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('marca_id')->unsigned();
			$table->string('modelo', 50);
			$table->integer('ano');
			$table->timestamps();
			$table->softDeletes();

			$table->engine = 'InnoDB';
      $table->charset = 'utf8';
      $table->collation = 'utf8_general_ci';

			$table->foreign('marca_id')->references('id')->on('marcas')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('carros');
	}

}
