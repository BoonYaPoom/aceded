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
        Schema::create('score', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('score_id');
            $table->integer('exam_id');
            $table->integer('usetime')->nullable();
            $table->integer('score')->nullable();
            $table->integer('fullscore')->nullable();
            $table->dateTime('startdate')->nullable();
            $table->dateTime('date')->nullable();
            $table->integer('uid');
            $table->integer('lesson_id')->nullable();
            $table->longText('question')->nullable()->collation('utf8_general_ci');
            $table->longText('answer')->nullable()->collation('utf8_general_ci');
            $table->longText('result')->nullable()->collation('utf8_general_ci');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('score');
    }
};
