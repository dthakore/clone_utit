<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ecom_order_subscription', function (Blueprint $table) {
            $table->foreign('order_id', 'order_fk_12')->references('order')->on('ecom_orders');
            $table->foreign('invoice_id', 'invoice_fk_5182360')->references('invoice_number')->on('ecom_order_invoices');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription', function (Blueprint $table) {
            //
        });
    }
}
