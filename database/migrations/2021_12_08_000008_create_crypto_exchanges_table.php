<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoExchangesTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_exchanges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->boolean('status')->default(0)->nullable();
            $table->boolean('is_visible')->default(0)->nullable();
            $table->string('tags')->nullable();
            $table->string('api_url')->nullable();
            $table->boolean('is_production')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
