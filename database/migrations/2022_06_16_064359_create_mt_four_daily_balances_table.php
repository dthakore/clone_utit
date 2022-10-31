<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtFourDailyBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mt_four_daily_balances', function (Blueprint $table) {
            $table->id();
            $table->string('account')->nullable();
            $table->string('email')->nullable();
            $table->string('agent')->nullable();
            $table->string('group')->nullable();
            $table->float('balance', 15, 5)->nullable();
            $table->float('equity', 15, 5)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mt_four_daily_balances');
    }
}
