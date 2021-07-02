<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reponses', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('enquete_id')->unsigned();
            $table->BigInteger('company_id')->unsigned();
            $table->BigInteger('emplacement_id')->unsigned()->nullable();
            $table->BigInteger('user_id')->unsigned()->nullable();
            $table->string('uniqid');
            $table->string('ip');

            $table->foreign('emplacement_id')->references('id')->on('emplacements');
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
        Schema::dropIfExists('reponses');
    }
}
