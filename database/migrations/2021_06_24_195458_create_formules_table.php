<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('online')->default(true);
            $table->double('price', 8.3)->default(0);
            $table->integer('nbsurvey')->default(1);
            $table->integer('nbmois')->default(1);
            $table->integer('nbsemplacements')->default(1);
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
        Schema::dropIfExists('formules');
    }
}
