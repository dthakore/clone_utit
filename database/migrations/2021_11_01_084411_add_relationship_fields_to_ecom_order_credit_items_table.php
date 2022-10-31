<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEcomOrderCreditItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ecom_order_credit_items', function (Blueprint $table) {
            $table->unsignedBigInteger('credit_memo_id');
            $table->foreign('credit_memo_id', 'credit_memo_fk_5183893')->references('id')->on('ecom_order_credit_memos');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_fk_5207701')->references('id')->on('ecom_orders');
            $table->unsignedBigInteger('order_line_item_id');
            $table->foreign('order_line_item_id', 'order_line_item_fk_5183894')->references('id')->on('ecom_order_line_item');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id', 'product_fk_5207702')->references('id')->on('ecom_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecom_order_credit_items', function (Blueprint $table) {
            //
        });
    }
}
