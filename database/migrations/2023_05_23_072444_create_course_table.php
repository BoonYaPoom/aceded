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
        Schema::create('course', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('course_id');
            $table->string('course_code', 10)->collation('utf8_general_ci');
            $table->string('course_th', 400)->collation('utf8_general_ci');
            $table->string('course_en', 400)->nullable()->collation('utf8_general_ci');
            $table->integer('group_id');
            $table->integer('levels')->nullable();
            $table->longText('subject')->nullable()->collation('utf8_general_ci');
            $table->string('recommended', 1)->nullable()->collation('utf8_general_ci');
            $table->longText('intro_th')->nullable()->collation('utf8_general_ci');
            $table->longText('intro_en')->nullable()->collation('utf8_general_ci');
            $table->longText('description_th')->nullable()->collation('utf8_general_ci');
            $table->longText('description_en')->nullable()->collation('utf8_general_ci');
            $table->longText('objectives_th')->nullable()->collation('utf8_general_ci');
            $table->longText('objectives_en')->nullable()->collation('utf8_general_ci');
            $table->longText('qualification_th')->nullable()->collation('utf8_general_ci');
            $table->longText('qualification_en')->nullable()->collation('utf8_general_ci');
            $table->longText('evaluation_th')->nullable()->collation('utf8_general_ci');
            $table->longText('evaluation_en')->nullable()->collation('utf8_general_ci');
            $table->longText('document_th')->nullable()->collation('utf8_general_ci');
            $table->longText('document_en')->nullable()->collation('utf8_general_ci');
            $table->longText('schedule_th')->nullable()->collation('utf8_general_ci');
            $table->longText('schedule_en')->nullable()->collation('utf8_general_ci');
            $table->string('evaluation', 1)->nullable()->collation('utf8_general_ci');
            $table->string('courseformat', 1)->nullable()->collation('utf8_general_ci');
            $table->integer('learnday')->nullable();
            $table->string('lesson_type', 1)->nullable()->collation('utf8_general_ci');
            $table->string('age', 200)->nullable()->collation('utf8_general_ci');
            $table->string('agework', 200)->nullable()->collation('utf8_general_ci');
            $table->string('person_type', 200)->nullable()->collation('utf8_general_ci');
            $table->string('position', 400)->nullable()->collation('utf8_general_ci');
            $table->string('position_type', 400)->nullable()->collation('utf8_general_ci');
            $table->string('position_level', 400)->nullable()->collation('utf8_general_ci');
            $table->string('education_level', 400)->nullable()->collation('utf8_general_ci');
            $table->string('course_status', 1)->collation('utf8_general_ci');
            $table->string('learn_format', 1)->nullable()->collation('utf8_general_ci');
            $table->string('shownumber', 1)->nullable()->collation('utf8_general_ci');
            $table->string('prerequisites', 400)->nullable()->collation('utf8_general_ci');
            $table->string('competencies', 400)->nullable()->collation('utf8_general_ci');
            $table->integer('checkscore')->nullable();
            $table->integer('checktime')->nullable();
            $table->string('survey_value', 50)->nullable()->collation('utf8_general_ci');
            $table->string('suvey_complacence', 50)->nullable()->collation('utf8_general_ci');
            $table->string('teacher', 200)->nullable()->collation('utf8_general_ci');
            $table->string('cover', 400)->nullable()->collation('utf8_general_ci');
            $table->string('virtualclassroom', 1)->nullable()->collation('utf8_general_ci');
            $table->longText('virtualclassroomlink')->nullable()->collation('utf8_general_ci');
            $table->dateTime('create_date')->nullable();
            $table->dateTime('update_date')->nullable();
            $table->string('templete_certificate', 2)->nullable()->collation('utf8_general_ci');
            $table->string('signature', 200)->nullable()->collation('utf8_general_ci');
            $table->integer('hours')->nullable();
            $table->integer('days')->nullable();
            $table->string('cert_custom', 200)->nullable()->collation('utf8_general_ci');
            $table->string('signature_name', 200)->nullable()->collation('utf8_general_ci');
            $table->string('signature_position', 200)->nullable()->collation('utf8_general_ci');
            $table->longText('result_learn_th')->nullable()->collation('utf8_general_ci');
            $table->longText('result_learn_en')->nullable()->collation('utf8_general_ci');
            $table->string('course_approve', 1)->nullable()->collation('utf8_general_ci');
            $table->string('cetificate_status', 1)->nullable()->collation('utf8_general_ci');
            $table->string('cetificate_request', 1)->nullable()->collation('utf8_general_ci');
            $table->string('paymentstatus', 1)->nullable()->collation('utf8_general_ci');
            $table->string('paymentmethod', 1)->nullable()->collation('utf8_general_ci');
            $table->float('price')->nullable();
            $table->string('discount', 1)->nullable()->collation('utf8_general_ci');
            $table->string('discount_type', 10)->nullable()->collation('utf8_general_ci');
            $table->string('discount_data', 200)->nullable()->collation('utf8_general_ci');
            $table->string('bank', 50)->nullable()->collation('utf8_general_ci');
            $table->string('compcode', 20)->nullable()->collation('utf8_general_ci');
            $table->string('taxid', 20)->nullable()->collation('utf8_general_ci');
            $table->string('suffixcode', 3)->nullable()->collation('utf8_general_ci');

            $table->string('accountbook', 20)->nullable()->collation('utf8_general_ci');
            $table->string('accountname', 50)->nullable()->collation('utf8_general_ci');
            $table->longText('paymentdetail')->nullable()->collation('utf8_general_ci');
            $table->dateTime('paymentdate')->nullable()->collation('utf8_general_ci');
            $table->string('promptpay', 1)->nullable()->collation('utf8_general_ci');
            $table->string('payinslip', 1)->nullable()->collation('utf8_general_ci');
            $table->string('creditcard', 1)->nullable()->collation('utf8_general_ci');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course');
    }
};
