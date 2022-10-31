<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLicenceKeyToOrderLineItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ecom_order_line_item', function (Blueprint $table) {
            $table->string('licence_key', 50)->nullable(true)->default(null);
            $table->dateTime('cycle_ends_at')->nullable(true);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_line_items', function (Blueprint $table) {
            $table->dropColumn('licence_key');
            $table->dropColumn('cycle_ends_at');

        });
    }
}
