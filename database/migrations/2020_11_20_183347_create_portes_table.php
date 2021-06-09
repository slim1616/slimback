<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portes', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->string('marque')->default('ZK Teco');
            $table->string('model')->nullable();
            $table->string('password')->nullable();
            $table->ipAddress('ip');
            $table->integer('port')->default(1671);
            $table->enum('type', ['in', 'out','inout'])->default('in');
            $table->enum('sdk', ['pull', 'standalone'])->default('pull');
            $table->enum('nature', ['access', 'pointage'])->default('access');
            $table->enum('status', ['Ok', 'wait','Error', 'disconnected'])->nullable();
            $table->timestamp('last_update_status')->nullable();	
            $table->boolean('rtlogshow')->default(false);
            $table->bigInteger('zone_id')->unsigned()->default(1);
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
            $table->bigInteger('batiment_id')->unsigned()->default(1);
            $table->foreign('batiment_id')->references('id')->on('batiments')->onDelete('cascade');
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
        Schema::dropIfExists('portes');
    }
}
