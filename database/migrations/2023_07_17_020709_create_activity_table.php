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
        Schema::create('activity', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('activity_id');
            $table->integer('category_id');
            $table->string('title', 400)->collation('utf8_general_ci');
            $table->longText('media')->nullable()->collation('utf8_general_ci');
            $table->longText('location')->nullable()->collation('utf8_general_ci');
            $table->longText('url')->nullable()->collation('utf8_general_ci');
            $table->date('startdate');
            $table->date('enddate');
            $table->string('starttime', 20)->nullable()->collation('utf8_general_ci');
            $table->string('endtime', 20)->nullable()->collation('utf8_general_ci');
            $table->string('frequency', 1)->nullable()->collation('utf8_general_ci');
            $table->longText('persontype')->nullable()->collation('utf8_general_ci');
            $table->string('comment', 1)->nullable()->collation('utf8_general_ci');
            $table->longText('options')->nullable()->collation('utf8_general_ci');
            $table->string('activity_status', 1)->collation('utf8_general_ci');
            $table->longText('detail')->collation('utf8_general_ci');
            $table->string('invite', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('uid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity');
    }
};
