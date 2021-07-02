<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSinglereponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('singlereponses', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('enquete_id')->unsigned();
            $table->BigInteger('company_id')->unsigned();
            $table->BigInteger('section_id')->unsigned();
            $table->BigInteger('reponse_id')->unsigned();
            $table->BigInteger('emplacement_id')->unsigned()->nullable();
            $table->BigInteger('user_id')->unsigned()->nullable();
            $table->string('uniqid');
            $table->string('ip');
            $table->json('reponse');

            $table->foreign('emplacement_id')->references('id')->on('emplacements');
            $table->foreign('reponse_id')->references('id')->on('reponses');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('enquete_id')->references('id')->on('enquetes')->onDelete('cascade');
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
        Schema::dropIfExists('singlereponses');
    }
}
