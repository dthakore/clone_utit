<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotSessionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('bot_session', function (Blueprint $table) {
            $table->unsignedBigInteger('bot_id');
            $table->foreign('bot_id', 'bot_id_fk_5441293')->references('id')->on('crypto_bots')->onDelete('cascade');
            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id', 'session_id_fk_5441293')->references('id')->on('crypto_sessions')->onDelete('cascade');
        });
    }
}
