<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmplacementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emplacements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->bigInteger('company_id')->unsigned()->default(1);
            $table->bigInteger('user_id')->unsigned()->default(1);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
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
        Schema::dropIfExists('emplacements');
    }
}
