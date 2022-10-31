<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtFourBrokersTable extends Migration
{
    public function up()
    {
        Schema::create('mt_four_brokers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('server_login');
            $table->string('server_password');
            $table->string('server_address');
            $table->integer('server_port');
            $table->integer('agent')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->nullable();
            $table->longText('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
