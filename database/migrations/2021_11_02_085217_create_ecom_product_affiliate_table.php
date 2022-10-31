<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomProductAffiliateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecom_product_affiliate', function (Blueprint $table) {
            $table->id();
            $table->integer('aff_level');
            $table->double('amount', 10, 0);
            $table->string('type_User_FAN')->nullable();
            $table->integer('is_delete')->nullable();
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
        Schema::dropIfExists('ecom_product_affiliate');
    }
}
