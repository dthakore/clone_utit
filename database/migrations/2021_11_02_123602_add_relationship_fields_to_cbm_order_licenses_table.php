<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCbmOrderLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cbm_order_licenses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_5183850')->references('id')->on('users');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_fk_5183801')->references('id')->on('ecom_orders');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id', 'product_fk_5207711')->references('id')->on('ecom_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cbm_order_licenses', function (Blueprint $table) {
            //
        });
    }
}
