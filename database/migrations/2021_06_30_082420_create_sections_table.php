<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('user_id')->unsigned();
            $table->BigInteger('enquete_id')->unsigned();
            $table->BigInteger('company_id')->unsigned();
            $table->string('type');
            $table->boolean('obligatoire')->default(true);
            $table->bigInteger('sectionnable_id')->unsigned();
            $table->string('sectionnable_type');
            $table->Integer('order')->unsigned();
            $table->enum('status', ['online', 'offline'])->default('online');
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
        Schema::dropIfExists('sections');
    }
}
