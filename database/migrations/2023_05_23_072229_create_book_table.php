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
        Schema::create('book', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('book_id')->start(10000)->nocache();
            $table->string('book_name', 400)->collation('utf8_general_ci');
		    $table->string('book_author', 400)->nullable()->collation('utf8_general_ci');
		    $table->string('cover', 400)->nullable()->collation('utf8_general_ci');
		    $table->string('bookfile', 400)->nullable()->collation('utf8_general_ci');
            $table->longText('detail')->nullable()->collation('utf8_general_ci');
            $table->longText('contents')->nullable()->collation('utf8_general_ci');
            $table->date('book_date');
            $table->date('book_update')->nullable();
		    $table->string('book_status', 1)->collation('utf8_general_ci');
            $table->string('book_type', 1)->collation('utf8_general_ci');
            $table->string('book_option', 400)->nullable()->nullable()->collation('utf8_general_ci');
            $table->string('recommended', 1)->collation('utf8_general_ci');
            $table->integer('category_id');
		    $table->string('book_member', 1)->nullable()->collation('utf8_general_ci');
            $table->string('book_year', 400)->nullable()->collation('utf8_general_ci');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book');
    }
};
