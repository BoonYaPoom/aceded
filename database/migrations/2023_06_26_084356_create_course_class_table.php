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
        Schema::create('course_class', function (Blueprint $table) {
        $table->charset = 'utf8';
        $table->collation = 'utf8_general_ci';
		$table->increments('class_id')->start(10000)->nocache();
        $table->string('class_name', 100)->collation('utf8_general_ci');
        $table->integer('course_id')->nullable();
        $table->string('startdate', 50)->collation('utf8_general_ci');
        $table->string('enddate', 50)->collation('utf8_general_ci');
        $table->integer('amount');
        $table->string('class_status', 1)->collation('utf8_general_ci');
        $table->string('registration', 1)->nullable()->collation('utf8_general_ci');
        $table->longText('registration_file')->nullable()->collation('utf8_general_ci');
        $table->dateTime('announcementdate')->nullable();
        $table->string('part3', 1)->nullable()->collation('utf8_general_ci');
        $table->longText('location')->nullable()->collation('utf8_general_ci');
        $table->string('orderby', 1)->nullable()->collation('utf8_general_ci');
        $table->string('selectby', 1)->nullable()->collation('utf8_general_ci');
        $table->dateTime('startcourse')->nullable();
        $table->dateTime('endcourse')->nullable();
        $table->string('ageofcert', 10)->nullable()->collation('utf8_general_ci');
        $table->dateTime('startregisterdate')->nullable();
        $table->dateTime('endregisterdate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_class');
    }
};
