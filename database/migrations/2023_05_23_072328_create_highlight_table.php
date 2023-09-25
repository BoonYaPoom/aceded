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
        Schema::create('highlight', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('highlight_id')->start(10000)->nocache();
            $table->string('highlight_path', 400)->collation('utf8_general_ci');
            $table->string('highlight_status', 1)->collation('utf8_general_ci');
            $table->text('highlight_link')->nullable()->collation('utf8_general_ci');
            $table->integer('department_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('highlight');
    }
};
