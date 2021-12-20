<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAbonnements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('formule_id')->unsigned()->default(1);
            $table->bigInteger('company_id')->unsigned()->default(1);
            $table->bigInteger('user_id')->unsigned()->default(1);
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('formule_id')->references('id')->on('formules');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('abonnements');
    }
}
