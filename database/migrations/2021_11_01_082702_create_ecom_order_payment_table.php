<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomOrderPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecom_order_payment', function (Blueprint $table) {
            $table->id();
            $table->double('total', 12, 5);
            $table->integer('payment_mode');
            $table->string('payment_ref_id')->nullable();
            $table->string('payment_comment')->nullable();
            $table->integer('payment_status');
            $table->datetime('payment_date')->nullable();
            $table->string('transaction_mode');
            $table->integer('denomination_id');
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
        Schema::dropIfExists('ecom_order_payment');
    }
}
