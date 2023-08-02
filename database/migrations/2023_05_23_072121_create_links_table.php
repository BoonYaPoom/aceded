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
        Schema::create('links', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('links_id');
            $table->string('links_title', 200)->collation('utf8_general_ci');
            $table->longText('links')->nullable()->collation('utf8_general_ci');
            $table->dateTime('links_date');
            $table->dateTime('links_update')->nullable();
            $table->string('links_status', 1)->collation('utf8_general_ci');
            $table->string('cover', 200)->nullable()->collation('utf8_general_ci');
            $table->integer('sort')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
