<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecom_order_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('invoice_number')->nullable();
            $table->datetime('invoice_date')->nullable();
            $table->integer('subscription_id');
            $table->integer('order_id')->nullable();
            $table->string('vat')->nullable();
            $table->float('vat_percentage', 5, 2)->nullable();
            $table->string('vat_number')->nullable();
            $table->string('company')->nullable();
            $table->string('building')->nullable();
            $table->string('street')->nullable();
            $table->string('region')->nullable();
            $table->string('postcode');
            $table->string('city');
            $table->decimal('order_total', 15, 2);
            $table->string('discount')->nullable();
            $table->string('net_total');
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('order_invoices');
    }
}
