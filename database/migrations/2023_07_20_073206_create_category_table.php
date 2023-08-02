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
        Schema::create('category', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('category_id');
            $table->string('category_th', 200)->collation('utf8_general_ci');
            $table->string('category_en', 200)->nullable()->collation('utf8_general_ci');
            $table->longText('detail_th')->nullable()->collation('utf8_general_ci');
            $table->longText('detail_en')->nullable()->collation('utf8_general_ci');
            $table->dateTime('category_date');
            $table->dateTime('category_update')->nullable();
            $table->string('category_status', 1)->collation('utf8_general_ci');
            $table->string('category_type', 1)->collation('utf8_general_ci');
            $table->string('category_option', 200)->collation('utf8_general_ci');
            $table->string('recommended', 1)->collation('utf8_general_ci');
            $table->integer('subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category');
    }
};
