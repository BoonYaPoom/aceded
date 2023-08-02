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
        Schema::create('activity_invite', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('invite_id');
            $table->integer('activity_id');
            $table->integer('uid')->nullable();
            $table->longText('message')->nullable()->collation('utf8_general_ci');
            $table->dateTime('date');
            $table->string('status',1)->collation('utf8_general_ci');
            $table->string('activity_type',1)->nullable()->collation('utf8_general_ci');
            $table->integer('from_id')->nullable();
            $table->integer('subject_id')->nullable();
            $table->string('msg',1)->nullable()->collation('utf8_general_ci');
            $table->integer('is_delete')->default(0);
            $table->dateTime('delete_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_invite');
    }
};
