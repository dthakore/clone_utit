<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoSymbolsTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_symbols', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('name');
            $table->string('code');
            $table->string('pair');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
