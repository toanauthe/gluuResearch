<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patient_users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('email');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->timestamp('birthday')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('active')->default(0);
            $table->tinyInteger('gender')->default(0);
            $table->string('phone_number');
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('deactivated_at')->nullable();
            $table->timestamp('password_changed_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_number_verified_at')->nullable();
            $table->timestamps();
        });
        Schema::create('consumer_patients', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_user_id')->index();
            $table->unsignedBigInteger('patient_id')->index();
            $table->foreign('patient_user_id')->references('id')->on('patient_users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumer_patients');
        Schema::dropIfExists('patient_users');
    }
};
