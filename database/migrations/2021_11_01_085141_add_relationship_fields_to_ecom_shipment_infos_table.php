<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEcomShipmentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ecom_shipment_infos', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_fk_5183881')->references('id')->on('ecom_orders');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id', 'product_fk_5207791')->references('id')->on('ecom_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ecom_shipment_infos', function (Blueprint $table) {
            //
        });
    }
}
