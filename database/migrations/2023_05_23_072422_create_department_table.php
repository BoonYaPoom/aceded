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
        Schema::create('department', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('department_id');
            $table->string('name_th', 400)->collation('utf8_general_ci');
            $table->string('name_en', 400)->nullable()->collation('utf8_general_ci');
            $table->string('name_short_th', 20)->nullable()->collation('utf8_general_ci');
            $table->string('name_short_en', 20)->nullable()->collation('utf8_general_ci');
            $table->integer('department_id_ref')->nullable();
            $table->string('department_status', 1)->nullable()->collation('utf8_general_ci');
            $table->string('color', 400)->nullable()->collation('utf8_general_ci');
   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department');
    }
};
