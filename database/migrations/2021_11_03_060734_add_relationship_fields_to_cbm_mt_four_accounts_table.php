<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCbmMtFourAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mt_four_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('broker_id')->nullable();
            $table->foreign('broker_id', 'broker_fk_5239816')->references('id')->on('mt_four_brokers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mt_four_accounts', function (Blueprint $table) {
            //
        });
    }
}
