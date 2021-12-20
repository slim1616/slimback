<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompagnebornesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compagnebornes', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('compagne_id')->unsigned();
            $table->BigInteger('borne_id')->unsigned();
            $table->BigInteger('company_id')->unsigned();
            $table->foreign('compagne_id')->references('id')->on('compagnes');
            $table->foreign('borne_id')->references('id')->on('bornes');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compagnebornes');
    }
}
