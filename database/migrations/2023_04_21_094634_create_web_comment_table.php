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
        Schema::create('web_comment', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('comment_id')->start(10000)->nocache();
            $table->integer('web_id');
            $table->longText('comment')->collation('utf8_general_ci');
            $table->dateTime('date');
            $table->string('status', 1)->collation('utf8_general_ci');
            $table->string('author', 100)->collation('utf8_general_ci');
            $table->integer('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_comment');
    }
};
