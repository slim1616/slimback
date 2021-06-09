<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employe_id')->unsigned()->default(0);
            $table->bigInteger('porte_id')->unsigned()->default(1);
            $table->datetime('datetime')->nullable();
            $table->string('VerifyType')->nullable();
            $table->string('VerifyState')->nullable();
            $table->string('workcode')->nullable();
            $table->string('eventtype')->nullable();
            $table->string('verified')->nullable();
            $table->bigInteger('zone_id')->unsigned()->default(0);
            $table->bigInteger('batiment_id')->unsigned()->default();
            $table->bigInteger('departement_id')->unsigned()->default();
            $table->string('nature_porte')->nullable();
            $table->string('type_emp')->default('employe');
            $table->json('emploi')->nullable();	
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->foreign('batiment_id')->references('id')->on('batiments');
            $table->foreign('departement_id')->references('id')->on('departements');
            // $table->foreign('employe_id')->references('id')->on('employes');
            $table->foreign('porte_id')->references('id')->on('portes');
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
        Schema::dropIfExists('historiques');
    }
}
