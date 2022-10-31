<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCourseLessonsTable extends Migration
{
    public function up()
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id', 'course_fk_5299640')->references('id')->on('courses');
        });
    }
}
