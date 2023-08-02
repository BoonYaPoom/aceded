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
        Schema::create('manual', function (Blueprint $table) {
            $table->increments('manual_id');
            $table->string('manual', 200)->collation('utf8_general_ci');
            $table->longText('manual_path')->collation('utf8_general_ci');
            $table->longText('detail')->nullable()->collation('utf8_general_ci');
            $table->string('manual_status', 1)->collation('utf8_general_ci');
            $table->string('manual_type', 1)->collation('utf8_general_ci');
            $table->string('cover', 200)->nullable()->collation('utf8_general_ci');
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual');
    }
};
