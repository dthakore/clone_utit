<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRankRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rank_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->foreign('rank_id', 'rank_fk_5183360')->references('id')->on('ranks');
            $table->unsignedBigInteger('rule_id')->nullable();
            $table->foreign('rule_id', 'rule_fk_5217628')->references('id')->on('rules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rank_rules', function (Blueprint $table) {
            //
        });
    }
}
