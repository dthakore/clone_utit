<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->foreign('sponsor_id', 'sponsor_fk_5182360')->references('id')->on('users');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id', 'country_fk_5207628')->references('id')->on('countries');
            $table->unsignedBigInteger('bus_address_country_id')->nullable();
            $table->foreign('bus_address_country_id', 'bus_address_country_fk_5207629')->references('id')->on('countries');
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->foreign('rank_id', 'rank_fk_5291272')->references('id')->on('ranks');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id', 'product_fk_2181272')->references('id')->on('ecom_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
