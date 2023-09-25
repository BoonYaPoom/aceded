<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_registration', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('registration_id')->start(10000)->nocache();
            $table->integer('user_id');
            $table->integer('class_id');
            $table->longText('profile')->collation('utf8_general_ci');
            $table->dateTime('registration_date')->nullable();
            $table->integer('registration_status')->nullable();
            $table->integer('department_id')->nullable();
            $table->string('registration_upload', 100)->nullable()->collation('utf8_general_ci');
            $table->integer('approve_by')->nullable();
            $table->dateTime('approve_date')->nullable();
            $table->longText('part3_data')->nullable()->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_registration');
    }
};
