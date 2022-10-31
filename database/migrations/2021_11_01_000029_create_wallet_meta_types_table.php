<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletMetaTypesTable extends Migration
{
    public function up()
    {
        Schema::create('wallet_meta_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_key');
            $table->string('reference_desc');
            $table->string('reference_data');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
