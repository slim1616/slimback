<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIconquestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iconquestions', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->unsigned();
            $table->uuid('enquete_id');
            $table->BigInteger('company_id')->unsigned();
            $table->string('textquestion')->nullable();
            $table->string('label')->nullable();
            $table->enum('typeIcon', ['star', 'face', 'face4', 'face5'])->nullable();
            $table->enum('question_type', ['icons', 'choix','stars'])->default('icons');
            $table->json('questions');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('enquete_id')->references('id')->on('enquetes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iconquestions');
    }
}
