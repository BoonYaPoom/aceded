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
            $table->increments('uid');
            $table->string('username', 50)->collation('utf8_general_ci');
            $table->string('firstname', 200)->collation('utf8_general_ci');
            $table->string('lastname', 200)->nullable()->collation('utf8_general_ci');
            $table->string('middlename', 200)->nullable()->collation('utf8_general_ci');
            $table->string('password', 255)->nullable()->collation('utf8_general_ci');
            $table->string('citizen_id', 13)->nullable()->collation('utf8_general_ci');
            $table->string('prefix', 3)->nullable()->collation('utf8_general_ci');
            $table->string('gender', 1)->nullable()->collation('utf8_general_ci');
            $table->string('email', 100)->nullable()->collation('utf8_general_ci');
            $table->string('role', 1)->collation('utf8_general_ci');
            $table->integer('per_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->string('permission', 50)->nullable()->collation('utf8_general_ci');
            $table->string('ldap', 50)->collation('utf8_general_ci');
            $table->string('userstatus', 50)->collation('utf8_general_ci');
            $table->dateTime('createdate')->nullable();
            $table->dateTime('modifieddate')->nullable();
            $table->string('createby', 50)->nullable()->collation('utf8_general_ci');
            $table->string('avatar', 100)->nullable()->collation('utf8_general_ci');
            $table->string('position', 100)->nullable()->collation('utf8_general_ci');
            $table->string('department', 100)->nullable()->collation('utf8_general_ci');
            $table->string('workplace', 100)->nullable()->collation('utf8_general_ci');
            $table->string('telephone', 50)->nullable()->collation('utf8_general_ci');
            $table->string('mobile', 50)->nullable()->collation('utf8_general_ci');
            $table->longText('socialnetwork')->nullable()->collation('utf8_general_ci');
            $table->longText('experience')->nullable()->collation('utf8_general_ci');
            $table->longText('skill')->nullable()->collation('utf8_general_ci');
            $table->string('recommened', 1)->nullable()->collation('utf8_general_ci');
            $table->string('templete', 50)->nullable()->collation('utf8_general_ci');
            $table->string('nickname', 50)->nullable()->collation('utf8_general_ci');
            $table->longText('introduce')->nullable()->collation('utf8_general_ci');
            $table->longText('bgcustom')->nullable()->collation('utf8_general_ci');
            $table->string('pay', 50)->nullable()->collation('utf8_general_ci');
            $table->longText('education')->nullable()->collation('utf8_general_ci');
            $table->longText('teach')->nullable()->collation('utf8_general_ci');
            $table->longText('modern')->nullable()->collation('utf8_general_ci');
            $table->longText('other')->nullable()->collation('utf8_general_ci');
            $table->longText('profiles')->nullable()->collation('utf8_general_ci');
            $table->string('editflag', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('pos_level')->nullable()->default(0);
            $table->string('pos_name', 50)->nullable()->collation('utf8_general_ci');
            $table->integer('sector_id')->nullable()->default(0);
            $table->integer('office_id')->nullable()->default(0);
            $table->string('user_type', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('province_id')->nullable()->default(0);
            $table->integer('district_id')->nullable()->default(0);
            $table->integer('subdistrict_id')->nullable()->default(0);
            $table->string('recoverpassword', 1)->nullable()->collation('utf8_general_ci');
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
