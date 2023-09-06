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
        Schema::create('media_category', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('category_id');
            $table->string('category_th', 400)->collation('utf8_general_ci');
            $table->string('category_en', 400)->nullable()->collation('utf8_general_ci');
            $table->longText('description_th')->nullable()->collation('utf8_general_ci');
            $table->longText('description_en')->nullable()->collation('utf8_general_ci');
            $table->dateTime('date');
            $table->string('status', 1)->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_category');
    }
};
