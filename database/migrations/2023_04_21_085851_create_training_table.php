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
        Schema::create('training', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('training_id')->nocache();
            $table->string('title', 400)->collation('utf8_general_ci');
            $table->string('institution', 400)->collation('utf8_general_ci');
            $table->string('attach', 100)->nullable()->collation('utf8_general_ci');
            $table->string('status', 1)->nullable()->collation('utf8_general_ci');
            $table->dateTime('dateTime')->nullable();
            $table->integer('user_id');
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training');
    }
};
