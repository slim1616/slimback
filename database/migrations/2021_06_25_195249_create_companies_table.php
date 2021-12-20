<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['Personnel','SUARL','SARL','SA'])->default('Personnel');
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->string('codetva')->nullable();
            $table->bigInteger('user_id')->unsigned()->default(1);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('company_id')->unsigned()->nullable();
            // $table->foreign('company_id')->references('id')->on('companies');
            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
