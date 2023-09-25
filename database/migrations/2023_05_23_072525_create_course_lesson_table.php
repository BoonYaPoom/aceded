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
        Schema::create('course_lesson', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('lesson_id')->start(10000)->nocache();
            $table->integer('subject_id');
            $table->string('lesson_number', 50)->nullable()->collation('utf8_general_ci');
            $table->string('lesson_th', 400)->collation('utf8_general_ci');
            $table->string('lesson_en', 400)->nullable()->collation('utf8_general_ci');
            $table->integer('lesson_id_ref')->nullable();
            $table->string('lesson_status', 1)->collation('utf8_general_ci');
            $table->integer('content_type');
            $table->string('content_path', 400)->nullable()->collation('utf8_general_ci');
            $table->integer('ordering')->nullable();
            $table->longText('permission')->nullable()->collation('utf8_general_ci');
            $table->string('exercise', 1)->nullable()->collation('utf8_general_ci');
            $table->longText('description')->nullable()->collation('utf8_general_ci');
            $table->longText('resultlesson')->nullable()->collation('utf8_general_ci');
            $table->float('duration')->nullable();
            $table->string('lessondocument', 400)->nullable()->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lesson');
    }
};
