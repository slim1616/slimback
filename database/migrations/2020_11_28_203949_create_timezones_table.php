<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimezonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timezones', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->time('heure_debut', 0)->default('00:00:00');	
            $table->time('heure_fin', 0)->default('24:00:00');	
            $table->integer('marge_entree');	
            $table->integer('marge_sortie');	
            $table->integer('marge_entree_retard');	
            $table->integer('marge_sortie_retard');	
            $table->json('planning')->nullable();	
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
        Schema::dropIfExists('timezones');
    }
}
