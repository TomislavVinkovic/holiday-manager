<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('vacation_requests', function(Blueprint $table) {
            
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('approved');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('vacation_requests');
    }
};
