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
        
            Schema::create('crackings', function (Blueprint $table) {
                $table->id();
                $table->integer('numbercigarette');
                $table->unsignedBigInteger('project_id');
                
                $table->timestamps();
            });
            
            Schema::table('crackings', function(Blueprint $table) {
                $table->foreign('project_id')->references('id')->on('projects');
             
            });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crackings');
    }
};
