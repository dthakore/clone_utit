<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomOrderCreditItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecom_order_credit_items', function (Blueprint $table) {
            $table->id();
            $table->string('product_sku')->nullable();
            $table->string('product_details')->nullable();
            $table->string('product_name')->nullable();
            $table->double('product_price', 12, 5);
            $table->string('product_country_name')->nullable();
            $table->integer('order_item_qty')->nullable();
            $table->integer('refund_item_qty')->nullable();
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
        Schema::dropIfExists('ecom_order_credit_items');
    }
}
