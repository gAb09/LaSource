<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('livraison_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->string('numero', 8);
            $table->integer('relais_id')->unsigned();
            $table->integer('modepaiement_id')->unsigned();
            $table->tinyInteger('is_actif')->default(1)->unsigned();
            $table->string('remarques', 2000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('commandes');
    }
}
