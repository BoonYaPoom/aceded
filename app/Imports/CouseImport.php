<?php

namespace App\Imports;

use App\Models\Course;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class CouseImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] >= 1) {

        return new Course([
            'course_id' => $row['0'],
            'course_code' => $row['1'],
            'course_th' => $row['2'],
            'course_en' => $row['3'],
            'group_id' => $row['4'],
            'subject' => $row['5'],
            'recommended' => $row['6'],
            'intro_th' => $row['7'],
            'intro_en' => $row['8'],
            'description_th' => $row['0'],
            'description_en' => $row['0'],
            'objectives_th' => $row['0'],
            'objectives_en' => $row['0'],
            'qualification_th' => $row['0'],
            'qualification_en' => $row['0'],
            'evaluation_th' => $row['0'],
            'evaluation_en' => $row['0'],
            'document_th' => $row['0'],
            'document_en' => $row['0'],
            'schedule_th' => $row['0'],
            'schedule_en' => $row['0'],
            'evaluation' => $row['0'],
            'courseformat' => $row['0'],
            'learnday' => $row['0'],
            'lesson_type' => $row['0'],
            'age' => $row['0'],
            'agework' => $row['0'],
            'person_type' => $row['0'],
            'position' => $row['0'],
            'position_type' => $row['0'],
            'position_level' => $row['0'],
            'education_level' => $row['0'],
            'course_status' => $row['0'],
            'learn_format' => $row['0'],
            'shownumber' => $row['0'],
            'prerequisites' => $row['0'],
            'competencies' => $row['0'],
            'checkscore' => $row['0'],
            'checktime' => $row['0'],
            'survey_value' => $row['0'],
            'suvey_complacence' => $row['0'],
            'teacher' => $row['0'],
            'virtualclassroom' => $row['0'],
            'virtualclassroomlink' => $row['0'],
            'create_date' => $row['0'],
            'templete_certificate' => $row['0'],
            'hours' => $row['0'],
            'days' => $row['0'],
            'signature_name' => $row['0'],
            'signature_position' => $row['0'],
            'result_learn_th' => $row['0'],
            'result_learn_en' => $row['0'],
            'course_approve' => $row['0'],
            'cetificate_status' => $row['0'],
            'cetificate_request' => $row['0'],
            'paymentstatus' => $row['0'],
            'paymentmethod' => $row['0'],
            'price' => $row['0'],
            'discount' => $row['0'],
            'discount_type' => $row['0'],
            'discount_data' => $row['0'],
            'bank' => $row['0'],
            'compcode' => $row['0'],
            'taxid' => $row['0'],
            'suffixcode' => $row['0'],
            'promptpay' => $row['0'],
            'accountbook' => $row['0'],
            'paymentdetail' => $row['0'],
        ]);
    }
    }
}
