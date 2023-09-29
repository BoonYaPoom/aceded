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
        Schema::create('users', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('user_id')->start(40000)->nocache();
            $table->string('username', 100)->collation('utf8_general_ci');
            $table->string('firstname', 400)->collation('utf8_general_ci');
            $table->string('lastname', 400)->nullable()->collation('utf8_general_ci');
            $table->string('middlename', 400)->nullable()->collation('utf8_general_ci');
            $table->string('password', 400)->nullable()->collation('utf8_general_ci');
            $table->string('citizen_id', 13)->nullable()->collation('utf8_general_ci');
            $table->string('prefix', 3)->nullable()->collation('utf8_general_ci');
            $table->string('gender', 1)->nullable()->collation('utf8_general_ci');
            $table->string('email', 100)->nullable()->collation('utf8_general_ci');
            $table->string('user_role', 1)->collation('utf8_general_ci');
            $table->integer('per_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->string('permission', 100)->nullable()->collation('utf8_general_ci');
            $table->string('ldap', 100)->collation('utf8_general_ci');
            $table->string('userstatus', 100)->collation('utf8_general_ci');
            $table->dateTime('createdate')->nullable();
            $table->dateTime('modifieddate')->nullable();
            $table->string('createby', 100)->nullable()->collation('utf8_general_ci');
            $table->string('avatar', 100)->nullable()->collation('utf8_general_ci');
            $table->string('user_position', 100)->nullable()->collation('utf8_general_ci');
            $table->string('department', 100)->nullable()->collation('utf8_general_ci');
            $table->string('workplace', 800)->nullable()->collation('utf8_general_ci');
            $table->string('telephone', 100)->nullable()->collation('utf8_general_ci');
            $table->string('mobile', 100)->nullable()->collation('utf8_general_ci');
            $table->longText('socialnetwork')->nullable()->collation('utf8_general_ci');
            $table->longText('experience')->nullable()->collation('utf8_general_ci');
            $table->longText('skill')->nullable()->collation('utf8_general_ci');
            $table->string('recommened', 1)->nullable()->collation('utf8_general_ci');
            $table->string('templete', 100)->nullable()->collation('utf8_general_ci');
            $table->string('nickname', 100)->nullable()->collation('utf8_general_ci');
            $table->longText('introduce')->nullable()->collation('utf8_general_ci');
            $table->longText('bgcustom')->nullable()->collation('utf8_general_ci');
            $table->string('pay', 100)->nullable()->collation('utf8_general_ci');
            $table->longText('education')->nullable()->collation('utf8_general_ci');
            $table->longText('teach')->nullable()->collation('utf8_general_ci');
            $table->longText('modern')->nullable()->collation('utf8_general_ci');
            $table->longText('other')->nullable()->collation('utf8_general_ci');
            $table->longText('profiles')->nullable()->collation('utf8_general_ci');
            $table->string('editflag', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('pos_level')->nullable()->default(0);
            $table->string('pos_name', 100)->nullable()->collation('utf8_general_ci');
            $table->integer('sector_id')->nullable()->default(0);
            $table->integer('office_id')->nullable()->default(0);
            $table->string('user_type', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('province_id')->nullable()->default(0);
            $table->integer('district_id')->nullable()->default(0);
            $table->integer('subdistrict_id')->nullable()->default(0);
            $table->string('recoverpassword', 1)->nullable()->collation('utf8_general_ci');
            $table->string('employeecode', 20)->nullable()->collation('utf8_general_ci');
            $table->string('organization', 400)->nullable()->collation('utf8_general_ci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
