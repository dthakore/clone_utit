<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomShipmentInfosTable extends Migration
{
    public function up()
    {
        Schema::create('ecom_shipment_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shipment_number')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
