<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCryptoCoversTable extends Migration
{
    public function up()
    {
        Schema::table('crypto_covers', function (Blueprint $table) {
            $table->unsignedBigInteger('bot_id')->nullable();
            $table->foreign('bot_id', 'bot_fk_5216801')->references('id')->on('crypto_bots');
        });
    }
}
