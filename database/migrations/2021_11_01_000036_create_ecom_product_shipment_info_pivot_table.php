<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomProductShipmentInfoPivotTable extends Migration
{
    public function up()
    {
        Schema::create('ecom_product_shipment_info', function (Blueprint $table) {
            $table->unsignedBigInteger('shipment_info_id');
            $table->foreign('shipment_info_id', 'shipment_info_id_fk_5239735')->references('id')->on('ecom_shipment_infos')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id', 'product_id_fk_5239735')->references('id')->on('ecom_products')->onDelete('cascade');
        });
    }
}
