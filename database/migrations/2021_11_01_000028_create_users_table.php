<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('api_token')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('language')->nullable();
            $table->string('is_enabled')->nullable();
            $table->string('is_active')->nullable();
            $table->string('building_num')->nullable();
            $table->string('street')->nullable();
            $table->string('region')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('business_name')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('bus_address_building_num')->nullable();
            $table->string('bus_address_street')->nullable();
            $table->string('bus_address_region')->nullable();
            $table->string('bus_address_city')->nullable();
            $table->string('bus_address_postcode')->nullable();
            $table->string('business_phone')->nullable();
            $table->integer('is_delete')->nullable();
            $table->string('image')->nullable();
            $table->string('token')->nullable();
            $table->integer('notification_mail')->nullable();
            $table->integer('marketting_mail')->nullable();
            $table->string('auth')->nullable();
            $table->integer('terms_conditions')->nullable();
            $table->integer('affiliate_disclosure')->nullable();
            $table->integer('privacy_disclosure')->nullable();
            $table->integer('reserve_wallet_commission_status')->nullable();
            $table->datetime('email_verified_at')->nullable();
            $table->boolean('approved')->default(0)->nullable();
            $table->boolean('verified')->default(0)->nullable();
            $table->datetime('verified_at')->nullable();
            $table->string('verification_token')->nullable();
            $table->boolean('two_factor')->default(0)->nullable();
            $table->string('remember_token')->nullable();
            $table->string('two_factor_code')->nullable();
            $table->datetime('two_factor_expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
