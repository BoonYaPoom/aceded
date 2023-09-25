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
        Schema::create('problem', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('problem_id')->start(10000)->nocache();
            $table->string('title', 400)->collation('utf8_general_ci');
            $table->string('detail', 400)->collation('utf8_general_ci');
            $table->string('firsname', 400)->collation('utf8_general_ci');
            $table->string('lastname', 400)->nullable()->collation('utf8_general_ci');
            $table->string('email', 400)->collation('utf8_general_ci');
            $table->string('telephone', 50)->collation('utf8_general_ci');
            $table->string('problem_type', 1)->collation('utf8_general_ci');
            $table->string('problem_status', 1)->collation('utf8_general_ci');
            $table->string('agent', 100)->nullable()->collation('utf8_general_ci');
            $table->string('platform', 100)->nullable()->collation('utf8_general_ci');
            $table->string('image', 400)->nullable()->collation('utf8_general_ci');
            $table->dateTime('problem_date')->nullable();
            $table->string('resolvedby', 1)->nullable()->collation('utf8_general_ci');
            $table->dateTime('resolveddate')->nullable();
            $table->string('resolved', 400)->nullable()->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problem');
    }
};
