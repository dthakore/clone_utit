<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCommissionRulesTable extends Migration
{
    public function up()
    {
        Schema::table('commission_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('commission_plan_id');
            $table->foreign('commission_plan_id', 'commission_plan_fk_5240420')->references('id')->on('commission_plans');
            $table->unsignedBigInteger('rank_id');
            $table->foreign('rank_id', 'rank_fk_5240475')->references('id')->on('ranks');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id', 'product_fk_5240423')->references('id')->on('ecom_products');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_5240424')->references('id')->on('ecom_product_categories');
            $table->unsignedBigInteger('wallet_type_id');
            $table->foreign('wallet_type_id', 'wallet_type_fk_5240427')->references('id')->on('wallet_types');
            $table->unsignedBigInteger('wallet_reference_id');
            $table->foreign('wallet_reference_id', 'wallet_reference_fk_5240428')->references('id')->on('wallet_meta_types');
            $table->unsignedBigInteger('denomination_id');
            $table->foreign('denomination_id', 'denomination_fk_5240429')->references('id')->on('denominations');
        });
    }
}
