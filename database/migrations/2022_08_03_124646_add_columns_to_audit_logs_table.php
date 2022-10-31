<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('model_name')->nullable()->after('subject_type');
            $table->string('user_email')->nullable()->after('user_id');
            $table->string('user_name')->nullable()->after('user_email');
            $table->string('action')->nullable()->after('user_name');
            $table->text('previous_properties')->nullable()->after('properties');
            $table->string('category')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            //
        });
    }
}
