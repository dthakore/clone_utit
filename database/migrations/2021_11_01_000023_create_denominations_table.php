<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenominationsTable extends Migration
{
    public function up()
    {
        Schema::create('denominations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('denomination_type');
            $table->string('sub_type');
            $table->string('label');
            $table->string('currency')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
