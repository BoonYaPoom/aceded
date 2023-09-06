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
        Schema::create('chatbot_message', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('chat_id');
            $table->string('to_user_id',50)->collation('utf8_general_ci');
            $table->string('from_user_id',50)->collation('utf8_general_ci');
            $table->longText('chat_message')->collation('utf8_general_ci');
            $table->dateTime('timestamp');
            $table->string('status',1)->nullable()->collation('utf8_general_ci');
            $table->string('answer',1)->nullable()->collation('utf8_general_ci');
            $table->string('question',100)->nullable()->collation('utf8_general_ci');
  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_message');
    }
};
