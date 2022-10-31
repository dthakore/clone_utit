<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoTradesTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_trades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('requested_amount', 15, 6);
            $table->string('side');
            $table->string('comment')->nullable();
            $table->string('failure_reason')->nullable();
            $table->string('exchange_order_status')->nullable();
            $table->string('original_orders')->nullable();
            $table->string('exchange_order_ref')->nullable();
            $table->string('exchange_trade_ref')->nullable();
            $table->float('requested_price', 15, 6);
            $table->float('requested_quantity', 15, 6);
            $table->float('executed_price', 15, 6);
            $table->float('executed_amount', 15, 6);
            $table->float('executed_quantity', 15, 6);
            $table->integer('status');
            $table->enum('trade_type', ['INITIAL-BUY','SELL-ALL','COVER-BUY','COVER-PROFIT','SELL-IND']);
            $table->datetime('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
