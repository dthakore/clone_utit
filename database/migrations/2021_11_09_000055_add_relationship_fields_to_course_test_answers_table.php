<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCourseTestAnswersTable extends Migration
{
    public function up()
    {
        Schema::table('course_test_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('test_result_id')->nullable();
            $table->foreign('test_result_id', 'test_result_fk_5299684')->references('id')->on('course_test_results');
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id', 'question_fk_5299685')->references('id')->on('course_questions');
            $table->unsignedBigInteger('option_id')->nullable();
            $table->foreign('option_id', 'option_fk_5299686')->references('id')->on('course_question_options');
        });
    }
}
