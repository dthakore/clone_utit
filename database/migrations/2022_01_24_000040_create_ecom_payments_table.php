<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('ecom_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('frontend_label');
            $table->string('is_active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
