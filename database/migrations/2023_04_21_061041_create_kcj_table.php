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
        Schema::create('kcj', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('kcj_id');
            $table->string('title', 250)->nullable()->collation('utf8_general_ci');
            $table->string('cover', 400)->nullable()->collation('utf8_general_ci');
            $table->string('pathfile', 400)->nullable()->collation('utf8_general_ci');
            $table->longText('detail')->nullable()->collation('utf8_general_ci');
            $table->string('createBy', 150)->nullable()->collation('utf8_general_ci');
            $table->dateTime('createDate');
            $table->string('kcj_Status', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('category_id')->nullable();
            $table->string('recommended', 1)->nullable()->collation('utf8_general_ci');
            $table->dateTime('updatedate');
            $table->longText('reference')->nullable()->collation('utf8_general_ci');
            $table->string('createby_position', 150)->nullable()->collation('utf8_general_ci');
            $table->string('kcj_case_id', 50)->nullable()->collation('utf8_general_ci');
            $table->string('kcj_member', 1)->nullable()->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kcj');
    }
};
