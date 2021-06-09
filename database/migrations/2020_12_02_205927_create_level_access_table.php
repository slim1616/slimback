<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acceslevels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employe_id')->unsigned()->default(1);
            $table->bigInteger('porte_id')->unsigned()->default(1);
            $table->bigInteger('timezone_id')->unsigned()->default(0);
            $table->foreign('employe_id')->references('id')->on('employes');
            $table->foreign('porte_id')->references('id')->on('portes');
            $table->foreign('timezone_id')->references('id')->on('timezones');
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
        Schema::dropIfExists('acceslevels');
    }
}
