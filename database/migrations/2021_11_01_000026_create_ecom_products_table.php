<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomProductsTable extends Migration
{
    public function up()
    {
        Schema::create('ecom_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->integer('agent')->nullable();
            $table->integer('licenses')->nullable();
            $table->string('is_active')->nullable();
            $table->string('is_featured')->nullable();
            $table->string('tag')->nullable();
            $table->string('image')->nullable();
            $table->integer('is_delete')->nullable();
            $table->string('is_subscription_enabled')->nullable();
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->datetime('sale_start_date')->nullable();
            $table->datetime('sale_end_date')->nullable();
            $table->decimal('level_one_affiliate', 12, 2)->default(0);
            $table->decimal('level_two_affiliate', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
