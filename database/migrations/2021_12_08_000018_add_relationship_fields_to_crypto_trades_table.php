<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCryptoTradesTable extends Migration
{
    public function up()
    {
        Schema::table('crypto_trades', function (Blueprint $table) {
            $table->unsignedBigInteger('bot_id');
            $table->foreign('bot_id', 'bot_fk_5210393')->references('id')->on('crypto_bots');
            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id', 'session_fk_5210394')->references('id')->on('crypto_sessions');
            $table->unsignedBigInteger('symbol_id')->nullable();
            $table->foreign('symbol_id', 'symbol_fk_5210395')->references('id')->on('crypto_symbols');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_5372401')->references('id')->on('users');
            $table->unsignedBigInteger('cover_id')->nullable();
            $table->foreign('cover_id', 'cover_fk_5437921')->references('id')->on('crypto_covers');
        });
    }
}
