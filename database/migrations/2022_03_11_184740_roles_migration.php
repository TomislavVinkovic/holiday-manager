<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up() {
        Schema::create('roles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('role');

            $table->timestamps();
        });

        //I will also create images here
        Schema::create('images', function(Blueprint $table) {
            $table->increments('id');
            $table->string('file_path');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('images');
    }
};
