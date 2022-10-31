<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllwallettransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('all_wallet_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_type')->nullable();
            $table->string('reference_num');
            $table->longText('transaction_comment')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('portal')->nullable();
            $table->decimal('amount', 15, 5);
            $table->bigInteger('payment_id')->nullable();
            $table->string('pay_address')->nullable();
            $table->bigInteger('purchase_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
