<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionPlansTable extends Migration
{
    public function up()
    {
        Schema::create('commission_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('is_active')->nullable();
            $table->string('table_name')->nullable();
            $table->string('action_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
