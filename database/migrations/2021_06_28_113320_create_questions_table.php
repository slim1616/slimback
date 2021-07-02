<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->enum('type', ['simple', 'quiz','multiple'])->default('simple');
            $table->json('options');
            $table->bigInteger('company_id')->unsigned()->default(1);
            $table->bigInteger('user_id')->unsigned()->default(1);
            $table->bigInteger('enquete_id')->unsigned()->default(1);
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('enquete_id')->references('id')->on('enquetes');
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
        Schema::dropIfExists('questions');
    }
}
