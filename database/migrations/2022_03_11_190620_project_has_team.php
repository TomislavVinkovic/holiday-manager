<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('project_has_team', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('project_id');
            $table->bigInteger('team_id');

            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('CASCADE');
            
            $table->foreign('team_id')
                  ->references('id')
                  ->on('teams')
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
        Schema::dropIfExists('project_has_team');
    }
};
