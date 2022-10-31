<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcomOrderSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecom_order_subscription', function (Blueprint $table) {
            $table->bigIncrements('subscription_id');
            $table->Integer('invoice_id')->nullable();
            $table->Integer('order_id');
            $table->string('licence_key');
            $table->integer('user_id');
            $table->enum('status', ['active','expired','canceled']);
            $table->dateTime('cycle_start_at')->nullable();
            $table->dateTime('cycle_end_at')->nullable();
            $table->dateTime('expire_on')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecom_order_subscription');
    }
}
