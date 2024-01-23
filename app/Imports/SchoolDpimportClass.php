<?php

namespace App\Imports;

use App\Models\UserDepartment;
use App\Models\Users;
use App\Models\UserSchool;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class SchoolDpimportClass implements ToModel
{
    /**
     * @param Collection $collection
     */
    private $department_id;
    private $extender_id;
    public function __construct($department_id, $extender_id)
    {
        $this->department_id = $department_id;
        $this->extender_id = $extender_id;
    }

    public function model(array $row)
    {

      
    }
}
