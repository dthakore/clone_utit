<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCourseQuestionOptionsTable extends Migration
{
    public function up()
    {
        Schema::table('course_question_options', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id', 'question_fk_5299670')->references('id')->on('course_questions');
        });
    }
}
