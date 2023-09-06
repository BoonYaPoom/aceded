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
        Schema::create('choice', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('choice_id');
            $table->string('question_id', 400)->collation('utf8_general_ci');
            $table->longText('detail')->nullable()->collation('utf8_general_ci');
            $table->integer('answer')->nullable();
            $table->string('status', 1)->collation('utf8_general_ci');
            $table->string('score', 5)->collation('utf8_general_ci');
            $table->integer('ordering');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choice');
    }
};
