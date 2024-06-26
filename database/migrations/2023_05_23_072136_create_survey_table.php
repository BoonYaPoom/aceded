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
        Schema::create('survey', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('survey_id')->start(10000)->nocache();
            $table->string('survey_th', 400)->collation('utf8_general_ci');
            $table->string('survey_en', 400)->nullable()->collation('utf8_general_ci');
            $table->longText('detail_th')->nullable()->collation('utf8_general_ci');
            $table->longText('detail_en')->nullable()->collation('utf8_general_ci');
            $table->dateTime('survey_date');
            $table->dateTime('survey_update')->nullable();
            $table->string('survey_status', 1)->collation('utf8_general_ci');
            $table->string('survey_type', 1)->default(0)->nullable(false)->collation('utf8_general_ci');
            $table->string('recommended', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('subject_id')->default(0)->nullable();
            $table->integer('class_id')->nullable();
            $table->string('cover', 400)->nullable()->collation('utf8_general_ci');
            $table->string('survey_lang', 2)->nullable()->default('th')->collation('utf8_general_ci');
            $table->integer('department_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey');
    }
};
