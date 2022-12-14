<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('contacts', function (Blueprint $table) {
        $table->id();
        $table->string('email');
        $table->integer('verified')->nullable();
        $table->string('firstname');
        $table->string('lastname');
        $table->string('token_verifi')->nullable();
        $table->unsignedBigInteger('user_id');
        $table->timestamps();
        });

    
        Schema::table('contacts', function(Blueprint $table) {
        $table->foreign('user_id')->references('id')->on('users');
     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
