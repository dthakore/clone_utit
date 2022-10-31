<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCryptoUserExchangesTable extends Migration
{
    public function up()
    {
        Schema::table('crypto_user_exchanges', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_5372229')->references('id')->on('users');
            $table->unsignedBigInteger('exchange_id');
            $table->foreign('exchange_id', 'exchange_fk_5209818')->references('id')->on('crypto_exchanges');
        });
    }
}
