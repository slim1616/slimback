<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquetes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->bigInteger('company_id')->unsigned()->default(1);
            $table->bigInteger('user_id')->unsigned()->default(1);
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->integer('objectif')->nullable()->default(100);
            $table->integer('questionParPage')->default(1);
            $table->enum('confidentiality', ['public','private'])->default('public');
            $table->boolean('online')->default(true);
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
        Schema::dropIfExists('enquetes');
    }
}
