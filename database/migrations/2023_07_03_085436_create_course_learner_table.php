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
        Schema::create('course_learner', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('learner_id')->start(10000)->nocache();
            $table->integer('class_id')->nullable();
            $table->integer('user_id');
            $table->dateTime('registerdate')->nullable();
            $table->string('learner_status', 1)->collation('utf8_general_ci');
            $table->integer('course_id')->nullable();
            $table->string('congratulation', 1)->nullable()->collation('utf8_general_ci');
            $table->dateTime('congratulationdate')->nullable();
            $table->date('surveydate')->nullable();
            $table->string('subject', 400)->nullable()->collation('utf8_general_ci');
            $table->dateTime('realcongratulationdate')->nullable();
            $table->string('request_certificate', 1)->nullable()->collation('utf8_general_ci');
            $table->string('approve_certificate', 1)->nullable()->collation('utf8_general_ci');
            $table->dateTime('printed_certificate')->nullable();
            $table->float('payment_amount')->nullable();
            $table->float('payment_price')->nullable();
            $table->string('payment_status', 1)->nullable()->collation('utf8_general_ci');
            $table->dateTime('payment_date')->nullable();
            $table->string('payment_file', 100)->nullable()->collation('utf8_general_ci');
            $table->string('payment_comment', 100)->nullable()->collation('utf8_general_ci');
            $table->string('payment_type', 100)->nullable()->collation('utf8_general_ci');
            $table->smallInteger('book_year')->nullable();
            $table->string('book_no', 20)->nullable()->collation('utf8_general_ci');
            $table->string('number_no', 20)->nullable()->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_learner');
    }
};
