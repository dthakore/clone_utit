<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomOrderCreditMemosTable extends Migration
{
    public function up()
    {
        Schema::create('ecom_order_credit_memos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('invoice_number')->nullable();
            $table->float('order_total', 12, 5);
            $table->float('vat', 12, 5);
            $table->float('refund_amount', 12, 5);
            $table->integer('memo_status');
            $table->timestamps();
        });
    }
}
