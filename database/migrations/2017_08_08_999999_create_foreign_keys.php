<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carros', function (Blueprint $table) {
            $table->foreign('marca')->references('id')->on('marcas')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });

        Schema::table('carros', function (Blueprint $table) {
            $table->foreign('modelo')->references('id')->on('modelos')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });

        Schema::table('modelos', function (Blueprint $table) {
            $table->foreign('marca')->references('id')->on('marcas')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carros', function (Blueprint $table) {
            $table->dropForeign('carros_id_marcas_foreign');
        });

        Schema::table('carros', function (Blueprint $table) {
            $table->dropForeign('carros_id_modelos_foreign');
        });

        Schema::table('modelos', function (Blueprint $table) {
            $table->dropForeign('modelos_id_marcas_foreign');
        });
    }
}
