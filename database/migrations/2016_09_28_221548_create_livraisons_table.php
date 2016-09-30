<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLivraisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('testingOk')->create('livraisons', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date_livraison')->default('2016-09-30 00:00:00');
            $table->timestamp('date_cloture')->default('2016-09-25 00:00:00');
            $table->timestamp('date_paiement')->default('2016-09-30 00:00:00');
            $table->integer('is_actived')->unsigned()->default(1);
            $table->integer('is_archived')->unsigned()->default(0);
            $table->string('remarques', 2000)->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::drop('livraisons');
    }
}
