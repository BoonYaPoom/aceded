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
        Schema::create('certificate_file', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('certificate_file_id')->start(100000)->nocache();
            $table->integer('user_id')->nullable();
            $table->string('file_name',800)->collation('utf8_general_ci')->nullable();
            $table->string('certificate_file_path',800)->collation('utf8_general_ci')->nullable();
            $table->dateTime('certificate_file_date')->nullable();
            $table->dateTime('certificate_file_enddate')->nullable();
            $table->string('certificate_file_role_status',1)->collation('utf8_general_ci')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_file');
    }
};
