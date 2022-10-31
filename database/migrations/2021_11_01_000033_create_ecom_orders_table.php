<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('ecom_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order')->nullable();
            $table->string('vat')->nullable();
            $table->float('vat_percentage', 5, 2)->nullable();
            $table->string('vat_number')->nullable();
            $table->string('company')->nullable();
            $table->string('order_status')->nullable();
            $table->string('order_origin')->nullable();
            $table->string('building')->nullable();
            $table->string('street')->nullable();
            $table->string('region')->nullable();
            $table->string('postcode');
            $table->string('city');
            $table->decimal('order_total', 15, 2);
            $table->string('discount')->nullable();
            $table->string('net_total');
            $table->integer('invoice_number')->nullable();
            $table->datetime('invoice_date')->nullable();
            $table->integer('is_subscription_enabled')->nullable();
            $table->longText('order_comment')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
            $table->string('voucher_code')->nullable();
            $table->float('voucher_discount', 5, 2)->nullable();
            $table->string('address_type');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
