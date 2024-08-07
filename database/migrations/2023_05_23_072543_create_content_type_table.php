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
        Schema::create('content_type', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('content_type')->start(10000)->nocache();
            $table->string('content_th', 50)->collation('utf8_general_ci');
            $table->string('content_en', 50)->nullable()->collation('utf8_general_ci');
            $table->string('icon', 50)->nullable()->collation('utf8_general_ci');
            $table->string('filetype', 100)->nullable()->collation('utf8_general_ci');
            $table->string('status', 1)->nullable()->collation('utf8_general_ci');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_type');
    }
};
