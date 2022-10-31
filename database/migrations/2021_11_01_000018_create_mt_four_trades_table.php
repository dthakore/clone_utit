<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtFourTradesTable extends Migration
{
    public function up()
    {
        Schema::create('mt_four_trades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('login')->nullable();
            $table->string('agent_number')->nullable();
            $table->string('ticket')->nullable();
            $table->string('symbol')->nullable();
            $table->string('ccy')->nullable();
            $table->string('type')->nullable();
            $table->float('lots', 12, 5)->nullable();
            $table->float('open_price', 12, 5)->nullable();
            $table->datetime('open_time')->nullable();
            $table->float('close_price', 12, 5)->nullable();
            $table->datetime('close_time')->nullable();
            $table->float('profit', 12, 5)->nullable();
            $table->float('commission', 12, 5)->nullable();
            $table->float('agent_commission', 12, 5)->nullable();
            $table->string('comment')->nullable();
            $table->string('magic_number')->nullable();
            $table->float('stop_loss', 12, 5)->nullable();
            $table->float('take_profit', 12, 5)->nullable();
            $table->float('swap', 12, 5)->nullable();
            $table->string('reason')->nullable();
            $table->integer('is_accounted_for')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
