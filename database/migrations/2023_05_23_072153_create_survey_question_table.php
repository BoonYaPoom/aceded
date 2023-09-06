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
        Schema::create('survey_question', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('question_id');
            $table->longText('question')->collation('utf8_general_ci');
            $table->string('question_type', 1)->collation('utf8_general_ci');
            $table->string('question_status', 1)->collation('utf8_general_ci');
            $table->string('opt', 1)->nullable()->collation('utf8_general_ci');
            $table->longText('choice1')->nullable()->collation('utf8_general_ci');
            $table->longText('choice2')->nullable()->collation('utf8_general_ci');
            $table->longText('choice3')->nullable()->collation('utf8_general_ci');
            $table->longText('choice4')->nullable()->collation('utf8_general_ci');
            $table->longText('choice5')->nullable()->collation('utf8_general_ci');
            $table->longText('choice6')->nullable()->collation('utf8_general_ci');
            $table->longText('choice7')->nullable()->collation('utf8_general_ci');
            $table->longText('choice8')->nullable()->collation('utf8_general_ci');
            $table->integer('ordering')->nullable();
            $table->integer('survey_id');
            $table->integer('subject_id')->nullable();
            $table->integer('numchoice')->nullable();
            $table->string('required', 1)->nullable()->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_question');
    }
};
