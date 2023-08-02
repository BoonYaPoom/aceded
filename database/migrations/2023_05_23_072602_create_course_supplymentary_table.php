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
        Schema::create('course_supplymentary', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('supplymentary_id');
            $table->string('title_th', 200)->collation('utf8_general_ci');
            $table->string('title_en', 200)->nullable()->collation('utf8_general_ci');
            $table->longText('path')->collation('utf8_general_ci');
            $table->longText('cover_image')->nullable()->collation('utf8_general_ci');
            $table->string('author', 100)->nullable()->collation('utf8_general_ci');
            $table->string('supplymentary_status', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('supplymentary_type');
            $table->integer('lesson_id')->nullable();
            $table->integer('subject_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_supplymentary');
    }
};
