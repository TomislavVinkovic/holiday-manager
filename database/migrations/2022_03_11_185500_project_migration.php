<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('projects', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('lead_id');
            $table->string('name', 255);
            $table->text('description');
            $table->bigInteger('logo_id');

            $table->foreign('lead_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('CASCADE');

            $table->foreign('logo_id')
                  ->references('id')
                  ->on('images')
                  ->onDelete('CASCADE');
            
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
        Schema::dropIfExists('projects');
    }
};
