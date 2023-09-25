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
        Schema::create('chat_message', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('chat_id')->start(10000)->nocache();
            $table->integer('to_user_id');
            $table->integer('from_user_id');
            $table->longText('chat_message')->collation('utf8_general_ci');
            $table->dateTime('dateTime');
            $table->string('status')->collation('utf8_general_ci');
            $table->integer('class_id')->nullable();
            $table->integer('subject_id')->nullable();
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_message');
    }
};
