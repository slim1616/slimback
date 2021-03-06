<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaillogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maillogs', function (Blueprint $table) {
            $table->id();
            $table->string('mail')->nullable()->default('mail');
            $table->boolean('sent')->nullable()->default(false);
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
        Schema::dropIfExists('maillogs');
    }
}
