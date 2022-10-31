<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPositionAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('user_position_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_account_num')->nullable();
            $table->string('login')->nullable();
            $table->string('type')->nullable();
            $table->string('email_address')->nullable();
            $table->string('beneficiary')->nullable();
            $table->string('agent_num')->nullable();
            $table->float('balance', 15, 5)->nullable();
            $table->float('equity', 15, 5)->nullable();
            $table->float('max_balance', 15, 5)->nullable();
            $table->float('max_equity', 15, 5)->nullable();
            $table->integer('matrix_node_num')->nullable();
            $table->integer('matrix')->nullable();
            $table->string('user_ownership')->nullable();
            $table->datetime('added_to_matrix_at')->nullable();
            $table->string('previous_login')->nullable();
            $table->integer('cluster')->nullable();
            $table->timestamps();
        });
    }
}
