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
        Schema::create('school', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('school_id')->start(200000)->nocache();
            $table->integer('school_code')->nullable();
            $table->string('school_name', 1600)->collation('utf8_general_ci');
            $table->integer('provinces_code')->nullable();
            $table->integer('subdistrict_code')->nullable();
            $table->integer('district_code')->nullable();
            $table->integer('department_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school');
    }
};
