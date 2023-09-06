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
        Schema::create('faq', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('faq_id');
            $table->string('faq', 400)->collation('utf8_general_ci');
            $table->longText('detail')->nullable()->collation('utf8_general_ci');
            $table->string('faq_status', 1)->collation('utf8_general_ci');
            $table->string('faq_type', 1)->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};
