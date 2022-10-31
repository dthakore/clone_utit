<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRanksTable extends Migration
{
    public function up()
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description');
            $table->integer('user_paid_out')->nullable();
            $table->string('abbreviation');
            $table->string('level')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
