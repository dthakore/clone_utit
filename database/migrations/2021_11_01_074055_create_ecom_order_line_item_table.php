<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomOrderLineItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecom_order_line_item', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->decimal('item_qty', 12, 5);
            $table->string('item_disc')->nullable();
            $table->double('item_price', 12, 5);
            $table->string('product_sku');
            $table->longText('comment')->nullable();
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
        Schema::dropIfExists('ecom_order_line_item');
    }
}
