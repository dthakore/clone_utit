<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCbmMtFourAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mt_four_accounts', function (Blueprint $table) {
            //$table->id();
            $table->string('login')->primary();
            $table->string('name')->nullable();
            $table->string('currency')->nullable();
            $table->float('balance', 15, 5)->nullable();
            $table->float('prev_balance', 15, 5)->nullable();
            $table->float('equity', 15, 5)->nullable();
            $table->float('prev_equity', 15, 5)->nullable();
            $table->string('email_address')->nullable();
            $table->string('group')->nullable();
            $table->string('agent')->nullable();
            $table->string('brand')->nullable();
            $table->datetime('registration_date')->nullable();
            $table->string('address')->nullable();
            $table->string('leverage')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->string('phone_number')->nullable();
            $table->float('max_equity', 15, 5)->nullable();
            $table->float('max_balance', 15, 5)->nullable();
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
        Schema::dropIfExists('mt_four_accounts');
    }
}
