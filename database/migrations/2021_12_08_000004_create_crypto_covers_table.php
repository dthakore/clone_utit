<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoCoversTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_covers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('index')->nullable();
            $table->float('cover_percentage')->nullable();
            $table->integer('buy_x_times')->nullable();
            $table->float('cover_pullback')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
