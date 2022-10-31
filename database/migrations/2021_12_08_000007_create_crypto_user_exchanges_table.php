<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoUserExchangesTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_user_exchanges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('key');
            $table->string('secret');
            $table->boolean('is_deleted')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
