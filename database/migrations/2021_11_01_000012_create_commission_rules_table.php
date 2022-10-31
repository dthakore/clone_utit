<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionRulesTable extends Migration
{
    public function up()
    {
        Schema::create('commission_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_level');
            $table->string('amount_type')->nullable();
            $table->float('amount', 12, 5);
            $table->string('wallet_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
