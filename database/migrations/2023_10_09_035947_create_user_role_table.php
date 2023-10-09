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
        Schema::create('user_role', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('user_role_id')->start(10)->nocache();
            $table->string('role_name',400)->collation('utf8_general_ci')->nullable();
            $table->string('role_cover_path',400)->collation('utf8_general_ci')->nullable();
            $table->string('role_status',1)->collation('utf8_general_ci')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role');
    }
};
