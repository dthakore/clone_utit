<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCbmLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbm_logs', function (Blueprint $table) {
            $table->id();
            $table->datetime('date')->nullable();
            $table->string('log')->nullable();
            $table->integer('status')->nullable();
            $table->string('timetaken')->nullable();
            $table->integer('total_accounts')->nullable();
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
        Schema::dropIfExists('cbm_logs');
    }
}
