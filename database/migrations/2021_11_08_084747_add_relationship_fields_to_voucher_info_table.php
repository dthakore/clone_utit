<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVoucherInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voucher_info', function (Blueprint $table) {
            $table->unsignedBigInteger('reference_id');
            $table->foreign('reference_id', 'reference_fk_5207711')->references('id')->on('voucher_reference');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_1183850')->references('id')->on('users');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_fk_5133801')->references('id')->on('ecom_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voucher_info', function (Blueprint $table) {
            //
        });
    }
}
