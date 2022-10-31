<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankRulesMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rank_rules_mapping', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('rank_id')->nullable();
            $table->foreign('rank_id', 'rank_id_fk_20220905')->references('id')->on('ranks');
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('rank_rules_mapping');
    }
}
