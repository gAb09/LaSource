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
        Schema::connection('testingOk')->create('indisponibiltes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('indisponible_id')->unsigned();
            $table->string('indisponible_type', 40);
            $table->string('indisponible_nom', 50);
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
        Schema::drop('indisponibiltes');
    }
}
