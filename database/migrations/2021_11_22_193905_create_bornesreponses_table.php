<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBornesreponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bornesreponses', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('company_id')->unsigned();
            $table->BigInteger('borne_id')->unsigned();
            $table->string('code_borne')->nullable();
            $table->Integer('resp')->unsigned();
            $table->dateTime('datetime');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('borne_id')->references('id')->on('bornes');
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
        Schema::dropIfExists('bornesreponses');
    }
}
