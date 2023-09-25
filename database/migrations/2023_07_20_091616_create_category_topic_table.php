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
        Schema::create('category_topic', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('topic_id')->start(10000)->nocache();
            $table->string('topic_th', 400)->collation('utf8_general_ci');
            $table->longText('topic_detail')->nullable()->collation('utf8_general_ci');
            $table->dateTime('topic_date');
            $table->dateTime('topic_update')->nullable();
            $table->string('topic_status', 1)->collation('utf8_general_ci');
            $table->string('topic_type', 1)->collation('utf8_general_ci');
            $table->string('topic_option', 400)->nullable()->nullable()->collation('utf8_general_ci');
            $table->integer('category_id')->nullable();
            $table->integer('topic_ref_id')->nullable();
            $table->integer('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_topic');
    }
};
