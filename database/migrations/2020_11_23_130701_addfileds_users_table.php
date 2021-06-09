<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddfiledsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->enum('sexe', ['M','F'])->default('M');
            $table->string('adress')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('avatar_id')->default(1);
            $table->boolean('active')->default(true);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
