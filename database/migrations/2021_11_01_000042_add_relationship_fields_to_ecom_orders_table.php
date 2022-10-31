<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEcomOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('ecom_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_5183890')->references('id')->on('users');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id', 'country_fk_5207705')->references('id')->on('countries');
        });
    }
}
