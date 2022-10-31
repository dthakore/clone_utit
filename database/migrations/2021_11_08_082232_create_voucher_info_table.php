<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_info', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_name')->nullable();
            $table->string('reference_data')->nullable();
            $table->string('voucher_code');
            $table->string('voucher_origin')->nullable();
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();
            $table->integer('voucher_status');
            $table->string('type')->nullable();
            $table->string('value')->nullable();
            $table->datetime('redeemed_at')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->nullable();
            $table->longText('voucher_comment');
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
        Schema::dropIfExists('voucher_info');
    }
}
