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
        Schema::create('users_extender2', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('extender_id')->nocache();
            $table->string('name', 800)->collation('utf8_general_ci');
            $table->integer('item_group_id')->nullable();
            $table->integer('item_parent_id')->nullable();
            $table->integer('item_lv')->nullable();
            $table->string('school_code', 400)->collation('utf8_general_ci')->nullable();
            $table->integer('school_province')->nullable();
            $table->integer('school_district')->nullable();
            $table->integer('school_subdistrict')->nullable();
            $table->integer('checked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_extender2');
    }
};
