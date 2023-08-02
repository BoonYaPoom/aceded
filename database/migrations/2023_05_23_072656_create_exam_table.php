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
        Schema::create('exam', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('exam_id');
            $table->string('exam_th', 200)->collation('utf8_general_ci');
            $table->string('exam_en', 200)->nullable()->collation('utf8_general_ci');
            $table->string('exam_type', 1)->collation('utf8_general_ci');
            $table->string('exam_status', 2)->collation('utf8_general_ci');
            $table->integer('exam_score');
            $table->longText('exam_options')->nullable()->collation('utf8_general_ci');
            $table->string('exam_select', 1)->nullable()->collation('utf8_general_ci');
            $table->longText('exam_data')->nullable()->collation('utf8_general_ci');
            $table->integer('maxtake')->nullable();
            $table->string('showscore', 1)->nullable()->collation('utf8_general_ci');
            $table->string('showanswer', 1)->nullable()->collation('utf8_general_ci');
            $table->string('randomquestion', 1)->nullable()->collation('utf8_general_ci');
            $table->string('randomchoice', 1)->nullable()->collation('utf8_general_ci');
            $table->string('limitdatetime', 1)->nullable()->collation('utf8_general_ci');
            $table->string('setdatetime', 200)->nullable()->collation('utf8_general_ci');
            $table->string('limittime', 1)->nullable()->collation('utf8_general_ci');
            $table->string('settime', 50)->nullable()->collation('utf8_general_ci');
            $table->string('survey_before', 1)->nullable()->collation('utf8_general_ci');
            $table->string('survey_after', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('lesson_id')->nullable();
            $table->integer('subject_id')->nullable();
            $table->integer('perpage')->nullable();
            $table->integer('score_pass')->nullable();
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam');
    }
};
