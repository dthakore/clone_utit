<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoSessionsTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status')->nullable();
            $table->decimal('lowest', 15, 2)->nullable();
            $table->decimal('highest', 15, 2)->nullable();
            $table->decimal('last_buy', 15, 2)->nullable();
            $table->decimal('average_buy', 15, 2)->nullable();
            $table->integer('total_buy')->nullable();
            $table->integer('cover')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
