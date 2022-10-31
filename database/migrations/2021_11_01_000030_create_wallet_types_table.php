<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTypesTable extends Migration
{
    public function up()
    {
        Schema::create('wallet_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wallet_type');
            $table->string('wallet_slug')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
