<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEcomOrderLineItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ecom_order_line_item', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_fk_5183890')->references('id')->on('ecom_orders');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id', 'product_fk_5207705')->references('id')->on('ecom_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecom_order_line_item', function (Blueprint $table) {
            //
        });
    }
}
