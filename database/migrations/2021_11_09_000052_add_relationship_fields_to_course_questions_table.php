<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCourseQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('course_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('test_id')->nullable();
            $table->foreign('test_id', 'test_fk_5299662')->references('id')->on('course_tests');
        });
    }
}
