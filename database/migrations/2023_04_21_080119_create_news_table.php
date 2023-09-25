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
        Schema::create('news', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('news_id')->start(10000)->nocache();
            $table->string('news_th', 400)->collation('utf8_general_ci');
            $table->string('news_en', 400)->nullable()->collation('utf8_general_ci');
            $table->longText('detail_th')->nullable()->collation('utf8_general_ci');
            $table->longText('detail_en')->nullable()->collation('utf8_general_ci');
            $table->longText('news_media')->nullable()->collation('utf8_general_ci');
            $table->dateTime('news_date');
            $table->dateTime('news_update')->nullable();
            $table->string('news_status', 1)->collation('utf8_general_ci');
            $table->string('recommended', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('subject_id');
            $table->integer('class_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
