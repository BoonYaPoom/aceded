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
        Schema::create('course_subject', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('subject_id');
            $table->string('subject_th', 200)->collation('utf8_general_ci');
            $table->string('subject_en', 200)->nullable()->collation('utf8_general_ci');
            $table->integer('department_id')->nullable();
            $table->string('subject_status', 1)->collation('utf8_general_ci');
            $table->longText('teacher')->nullable()->collation('utf8_general_ci');
            $table->string('subject_code', 12)->nullable()->collation('utf8_general_ci');
            $table->longText('intro_th')->nullable()->collation('utf8_general_ci');
            $table->longText('intro_en')->nullable()->collation('utf8_general_ci');
            $table->longText('description_th')->nullable()->collation('utf8_general_ci');
            $table->longText('description_en')->nullable()->collation('utf8_general_ci');
            $table->longText('objectives_th')->nullable()->collation('utf8_general_ci');
            $table->longText('objectives_en')->nullable()->collation('utf8_general_ci');
            $table->longText('qualification_th')->nullable()->collation('utf8_general_ci');
            $table->longText('qualification_en')->nullable()->collation('utf8_general_ci');
            $table->longText('evaluation_th')->nullable()->collation('utf8_general_ci');
            $table->longText('evaluation_en')->nullable()->collation('utf8_general_ci');
            $table->longText('document_th')->nullable()->collation('utf8_general_ci');
            $table->longText('document_en')->nullable()->collation('utf8_general_ci');
            $table->longText('schedule_th')->nullable()->collation('utf8_general_ci');
            $table->longText('schedule_en')->nullable()->collation('utf8_general_ci');
            $table->dateTime('create_date')->nullable();
            $table->dateTime('update_date')->nullable();
            $table->longText('setting')->nullable()->collation('utf8_general_ci');
            $table->longText('permission')->nullable()->collation('utf8_general_ci');
            $table->string('learn_format', 1)->nullable()->collation('utf8_general_ci');
            $table->string('evaluation', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('checkscore')->nullable();
            $table->integer('checktime')->nullable();
            $table->longText('banner')->nullable()->collation('utf8_general_ci');
            $table->string('subject_approve', 1)->nullable()->collation('utf8_general_ci');
            $table->longText('result_learn_th')->nullable()->collation('utf8_general_ci');
            $table->longText('result_learn_en')->nullable()->collation('utf8_general_ci');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_subject');
    }
};
