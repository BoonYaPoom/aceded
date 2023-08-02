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
        Schema::create('course_group', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('group_id');
            $table->string('group_th', 200)->collation('utf8_general_ci');
            $table->string('group_en', 200)->nullable()->collation('utf8_general_ci');
            $table->integer('department_id')->nullable();
            $table->string('group_status', 1)->collation('utf8_general_ci');
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_group');
    }
};
