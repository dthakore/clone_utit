<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCryptoBotsTable extends Migration
{
    public function up()
    {
        Schema::table('crypto_bots', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_5210219')->references('id')->on('users');
            $table->unsignedBigInteger('user_exchange_id');
            $table->foreign('user_exchange_id', 'user_exchange_fk_5210220')->references('id')->on('crypto_user_exchanges');
            $table->unsignedBigInteger('symbol_id');
            $table->foreign('symbol_id', 'symbol_fk_5210221')->references('id')->on('crypto_symbols');
        });
    }
}
