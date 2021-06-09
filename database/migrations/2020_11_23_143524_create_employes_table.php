<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->nullable();
            $table->string('fonction')->nullable();
            $table->string('matricule')->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->enum('sexe', ['M','F'])->default('M');
            $table->string('adress')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('avatar_id')->default(1);
            $table->boolean('active')->default(true);
            $table->string('cardNo')->nullable();
            $table->text('fingerPrint1')->nullable();
            $table->text('fingerPrint2')->nullable();
            $table->time('heure_debut', 0)->default('00:00:00');	
            $table->time('heure_fin', 0)->default('24:00:00');	
            $table->integer('marge_entree')->default(0);	
            $table->integer('marge_sortie')->default(0);	
            $table->integer('marge_entree_retard')->default(0);	
            $table->integer('marge_sortie_retard')->default(0);	
            $table->json('emploi')->nullable();	
            $table->enum('type', ['employe','visiteur','intervenant'])->default('employe');
            $table->bigInteger('departement_id')->unsigned()->default(1);
            $table->foreign('departement_id')->references('id')->on('departements');
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
        Schema::dropIfExists('employes');
    }
}
