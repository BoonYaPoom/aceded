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
        Schema::create('positions', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('position_id')->start(10000)->nocache();
            $table->string('position_th', 400)->nullable()->collation('utf8_general_ci');
            $table->string('position_en', 400)->nullable()->collation('utf8_general_ci');
            $table->string('position_code', 10)->nullable()->collation('utf8_general_ci');
            $table->string('position_type', 1)->nullable()->collation('utf8_general_ci');
            $table->string('position_status', 1)->nullable()->collation('utf8_general_ci');
            $table->string('position_level_min', 2)->nullable()->collation('utf8_general_ci');
            $table->string('position_level_max', 2)->nullable()->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
