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
        Schema::create('logs', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('logsid');
            $table->integer('uid');
            $table->dateTime('logdate');
            $table->string('logip', 30)->collation('utf8_general_ci');
            $table->string('logagents', 30)->collation('utf8_general_ci');
            $table->string('logplatform', 30)->collation('utf8_general_ci');
            $table->tinyInteger('logid');
            $table->tinyInteger('logaction')->nullable();
            $table->string('logdetail', 400)->nullable()->collation('utf8_general_ci');
            $table->integer('idref')->nullable();
            $table->integer('subject_id')->nullable();
            $table->integer('duration')->nullable();
            $table->string('status', 1)->nullable()->collation('utf8_general_ci');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
