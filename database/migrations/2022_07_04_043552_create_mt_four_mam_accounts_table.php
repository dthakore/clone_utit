<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtFourMamAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mt_four_mam_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id', 'account_id_fk_5158973')->references('id')->on('mt_four_accounts')->onDelete('cascade');
            $table->integer('login')->nullable();
            $table->integer('agent')->nullable();
            $table->string('group')->nullable();
            $table->string('broker')->nullable();
            $table->string('asset_manager')->nullable();
            $table->string('agent_name')->nullable();
            $table->integer('minimum_deposit')->nullable();
            $table->integer('parent_agent')->nullable();
            $table->string('brand_name')->nullable();
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
        Schema::dropIfExists('mt_four_mam_accounts');
    }
}
