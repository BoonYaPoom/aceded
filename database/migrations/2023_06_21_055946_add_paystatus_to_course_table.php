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
        Schema::table('course', function (Blueprint $table) {
            $table->string('paymentstatus', 1)->nullable()->collation('utf8_general_ci');
            $table->string('paymentmethod', 1)->nullable()->collation('utf8_general_ci');
            $table->float('price')->nullable();
            $table->string('discount', 1)->nullable()->collation('utf8_general_ci');
            $table->string('discount_type', 10)->nullable()->collation('utf8_general_ci');
            $table->string('discount_data', 100)->nullable()->collation('utf8_general_ci');
            $table->string('bank', 50)->nullable()->collation('utf8_general_ci');
            $table->string('compcode', 20)->nullable()->collation('utf8_general_ci');
            $table->string('taxid', 20)->nullable()->collation('utf8_general_ci');
            $table->string('suffixcode', 3)->nullable()->collation('utf8_general_ci');
            $table->string('promptpay', 20)->nullable()->collation('utf8_general_ci');
            $table->string('accountbook', 20)->nullable()->collation('utf8_general_ci');
            $table->longText('paymentdetail')->nullable()->collation('utf8_general_ci');
     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course', function (Blueprint $table) {
            //
        });
    }
};
