<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEcomProductsTable extends Migration
{
    public function up()
    {
        Schema::table('ecom_products', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_5183756')->references('id')->on('ecom_product_categories');
        });
    }
}
