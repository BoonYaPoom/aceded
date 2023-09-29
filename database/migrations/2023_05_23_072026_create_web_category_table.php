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
        Schema::create('web_category', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('category_id')->start(10000)->nocache();
            $table->string('category_th', 400)->collation('utf8_general_ci');
            $table->string('category_en', 400)->nullable()->collation('utf8_general_ci');
            $table->longText('detail_th')->nullable()->collation('utf8_general_ci');
            $table->longText('detail_en')->nullable()->collation('utf8_general_ci');
            $table->dateTime('category_date');
            $table->dateTime('category_update')->nullable();
            $table->string('category_status', 1)->collation('utf8_general_ci');
            $table->string('category_type', 1)->nullable()->collation('utf8_general_ci');
            $table->string('category_option', 400)->nullable()->collation('utf8_general_ci');
            $table->string('recommended', 1)->collation('utf8_general_ci');
            $table->string('cover', 400)->nullable()->collation('utf8_general_ci');
            $table->integer('department_id')->nullable();
            $table->string('startdate', 50)->collation('utf8_general_ci')->nullable();
            $table->string('enddate', 50)->collation('utf8_general_ci')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_category');
    }
};
