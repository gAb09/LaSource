<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLignesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lignes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('commande_id')->unsigned();
            $table->integer('panier_id')->unsigned();
            $table->integer('quantite')->unsigned();
            $table->decimal('prix_final', 6, 2);
            $table->integer('producteur_id')->unsigned();
            $table->string('panier');
            $table->string('producteur');
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
