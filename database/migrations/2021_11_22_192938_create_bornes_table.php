<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBornesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bornes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code_borne')->nullable();
            $table->string('ip')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->BigInteger('company_id')->unsigned();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bornes');
    }
}
