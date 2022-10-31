<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAllwallettransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('all_wallet_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_5182726')->references('id')->on('users');
            $table->unsignedBigInteger('wallet_type_id');
            $table->foreign('wallet_type_id', 'wallet_type_fk_5182727')->references('id')->on('wallet_types');
            $table->unsignedBigInteger('reference_id');
            $table->foreign('reference_id', 'reference_fk_5182729')->references('id')->on('wallet_meta_types');
            $table->unsignedBigInteger('denomination_id');
            $table->foreign('denomination_id', 'denomination_fk_5182732')->references('id')->on('denominations');
        });
    }
}
