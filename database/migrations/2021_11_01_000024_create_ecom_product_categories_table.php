<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomProductCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('ecom_product_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('is_active')->nullable();
            $table->integer('is_delete')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
