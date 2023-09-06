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
        Schema::create('media', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('media_id');
            $table->integer('category_id');
            $table->string('media_th', 400)->collation('utf8_general_ci');
            $table->string('media_en', 400)->collation('utf8_general_ci');
            $table->longText('description_th')->nullable()->collation('utf8_general_ci');
            $table->longText('description_en')->nullable()->collation('utf8_general_ci');
            $table->longText('path')->collation('utf8_general_ci');
            $table->dateTime('date');
            $table->string('status', 1)->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
