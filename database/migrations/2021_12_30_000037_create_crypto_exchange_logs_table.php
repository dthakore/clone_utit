<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoExchangeLogsTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_exchange_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->text('error')->nullable();
            $table->longText('log')->nullable();
            $table->integer('order_id')->nullable();
            $table->string('exchange')->nullable();
            $table->text('request')->nullable();
            $table->timestamps();
        });
    }
}
