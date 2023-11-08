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
        Schema::create('submit_school', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('submit_school_id')->start(10)->nocache();
            $table->integer('school_id')->nullable();
            $table->integer('provines')->nullable();
            $table->string('path_sub',800)->collation('utf8_general_ci')->nullable();
            $table->string('role_status',1)->collation('utf8_general_ci')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submit_school');
    }
};
