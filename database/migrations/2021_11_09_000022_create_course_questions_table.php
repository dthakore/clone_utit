<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('course_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question_text')->nullable();
            $table->integer('points')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
