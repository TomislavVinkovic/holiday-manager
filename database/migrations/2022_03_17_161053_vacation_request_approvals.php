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
        Schema::create('vacation_request_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vacation_request_id');
            $table->bigInteger('lead_id');
            
            $table->foreign('vacation_request_id')
                  ->references('id')
                  ->on('vacation_requests')
                  ->onDelete('CASCADE');
            
            $table->foreign('lead_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('vacation_request_approvals');
    }
};
