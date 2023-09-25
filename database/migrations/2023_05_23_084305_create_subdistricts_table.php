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
        Schema::create('subdistricts', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id')->start(10000)->nocache();
            $table->integer('code');
            $table->string('name_in_thai', 150)->collation('utf8_general_ci');
            $table->string('name_in_english', 150)->nullable()->collation('utf8_general_ci');
            $table->decimal('latitude',6,3);
            $table->decimal('longitude',6,3);
            $table->integer('district_id');
            $table->integer('zip_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subdistricts');
    }
};
