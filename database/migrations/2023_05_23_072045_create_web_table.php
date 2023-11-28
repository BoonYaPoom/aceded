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
        Schema::create('web', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('web_id')->start(100000)->nocache();
            $table->string('web_th', 900)->collation('utf8_general_ci');
            $table->string('web_en', 900)->nullable()->collation('utf8_general_ci');
            $table->longText('detail_th')->nullable()->collation('utf8_general_ci');
            $table->longText('detail_en')->nullable()->collation('utf8_general_ci');
            $table->dateTime('web_date');
            $table->dateTime('web_update')->nullable();
            $table->string('web_status', 1)->collation('utf8_general_ci');
            $table->string('web_type', 1)->nullable()->collation('utf8_general_ci');
            $table->string('web_option', 400)->nullable()->collation('utf8_general_ci');
            $table->string('cover', 400)->nullable()->collation('utf8_general_ci');
            $table->string('startdate', 300)->collation('utf8_general_ci')->nullable();
            $table->string('enddate', 300)->collation('utf8_general_ci')->nullable();
            $table->string('recommended', 1)->collation('utf8_general_ci');
            $table->integer('category_id');
            $table->integer('sort')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web');
    }
};
