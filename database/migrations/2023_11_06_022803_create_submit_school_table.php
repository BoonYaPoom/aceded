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
        Schema::create('submit_school', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('submit_id')->start(10)->nocache();
            $table->integer('user_id')->nullable();
            $table->integer('school_code')->nullable();
            $table->integer('provines_code')->nullable();
            $table->string('firstname',800)->collation('utf8_general_ci')->nullable();
            $table->string('lastname',800)->collation('utf8_general_ci')->nullable();
            $table->string('telephone',100)->collation('utf8_general_ci')->nullable();
            $table->string('email',800)->collation('utf8_general_ci')->nullable();
            $table->string('citizen_id',100)->collation('utf8_general_ci')->nullable();
            $table->string('pos_name',800)->collation('utf8_general_ci')->nullable();
            $table->string('submit_path',800)->collation('utf8_general_ci')->nullable();
            $table->string('submit_status',1)->collation('utf8_general_ci')->nullable();
            $table->dateTime('startdate')->nullable();
            $table->dateTime('enddate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submit_school');
    }
};
