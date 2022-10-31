<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCryptoSessionsTable extends Migration
{
    public function up()
    {
        Schema::table('crypto_sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('bot_id');
            $table->foreign('bot_id', 'bot_fk_5210348')->references('id')->on('crypto_bots');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_5372400')->references('id')->on('users');
        });
    }
}
