<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoBotsTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_bots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->double('balance');
            $table->boolean('is_cycle')->default(0)->nullable();
            $table->boolean('init_immediate')->default(0)->nullable();
            $table->double('init_amount');
            $table->double('init_buy_at')->nullable();
            $table->double('init_pullback')->nullable();
            $table->double('take_profit_average_percentage');
            $table->double('take_profit_average_retracement');
            $table->integer('take_profit_independent_cover');
            $table->double('take_profit_independent_percentage')->nullable();
            $table->double('take_profit_independent_retracement')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->integer('active_session_id')->nullable();
            $table->boolean('is_simulated')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
