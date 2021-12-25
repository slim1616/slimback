<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnqueteemplacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enqueteemplacements', function (Blueprint $table) {
            $table->id();
            $table->uuid('emplacement_id');
            $table->uuid('enquete_id');
            $table->BigInteger('company_id')->unsigned();
            $table->string('password')->nullable();
            $table->foreign('emplacement_id')->references('id')->on('emplacements');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('enquete_id')->references('id')->on('enquetes')->onDelete('cascade');
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
        Schema::dropIfExists('enqueteemplacements');
    }
}
