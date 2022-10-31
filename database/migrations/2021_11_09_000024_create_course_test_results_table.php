<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTestResultsTable extends Migration
{
    public function up()
    {
        Schema::create('course_test_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('score')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
