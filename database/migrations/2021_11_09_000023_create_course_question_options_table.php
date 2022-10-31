<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseQuestionOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('course_question_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('option_text')->nullable();
            $table->boolean('is_correct')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
