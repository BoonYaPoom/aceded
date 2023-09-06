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
        Schema::create('department_tot', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('dep_id');
            $table->string('dep_parent', 50)->nullable()->collation('utf8_general_ci');
            $table->string('cdiv', 12)->nullable()->collation('utf8_general_ci');
            $table->longText('dep_title')->nullable()->collation('utf8_general_ci');
            $table->string('initial', 12)->nullable()->collation('utf8_general_ci');
            $table->integer('dep_weight')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_tot');
    }
};
