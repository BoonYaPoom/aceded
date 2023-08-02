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
        Schema::create('blog', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('blog_id');
            $table->string('title',200)->collation('utf8_general_ci');
            $table->string('title_en',200)->default('')->collation('utf8_general_ci');
            $table->longText('detail')->collation('utf8_general_ci');
            $table->longText('detail_en')->collation('utf8_general_ci');
            $table->dateTime('date');
            $table->string('blog_status',1)->collation('utf8_general_ci');
            $table->string('author',100)->nullable()->collation('utf8_general_ci');
            $table->string('comment',1)->collation('utf8_general_ci');
            $table->string('recommended',1)->nullable()->collation('utf8_general_ci');
            $table->longText('options')->nullable()->collation('utf8_general_ci');
            $table->integer('uid');
            $table->integer('category_id');
            $table->integer('sort')->nullable();
            $table->string('groupselect',1)->nullable()->collation('utf8_general_ci');
            $table->string('templete',2)->nullable()->collation('utf8_general_ci');
            $table->string('bgcustom',100)->nullable()->collation('utf8_general_ci');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
};
