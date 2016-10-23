<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndisponibilitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('testingOk')->create('indisponibilites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('indisponisable_id')->unsigned();
            $table->string('indisponisable_type', 40);
            $table->string('indisponisable_nom', 50);
            $table->timestamp('date_debut')->default('0000-00-00 00:00:00');
            $table->timestamp('date_fin')->default('0000-00-00 00:00:00');
            $table->string('cause', 25);
            $table->string('remarques', 2000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('indisponibilites');
    }
}
