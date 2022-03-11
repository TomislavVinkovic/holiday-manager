<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('team_has_user', function (Blueprint $table) {
            $table->bigInteger('user_id')->unique()->change();
            $table->bigInteger('team_id')->unique()->change();
        });

        Schema::table('vacation_requests', function (Blueprint $table) {
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
};
