<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Provinces;
use App\Models\School;
use App\Models\Users;
use App\Models\UserSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SchoolController extends Controller
{
    public function schoolManage()
    {
        set_time_limit(0);
        $users = Users::all();
        $userschool = UserSchool::all();
        $school = School::all();

        return view('page.UserAdmin.group.umsschool.index', compact('users', 'school', 'userschool'));
    }
    public function getSchools2(Request $request)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 300);
        ini_set('pcre.backtrack_limit', 5000000);
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowPerPage = $request->get('length');
        $orderArray = $request->get('order');
        $columnsNameArray = $request->get('columns');
        $searchArray = $request->get('search');
        $columnIndex = $request->get('column');
        $columnsName = $columnsNameArray[$columnIndex]['datas'];

        $columSortOrder = $orderArray[0]['dir'];
        $searchValue = $searchArray['value'];


        $schoolsdata = School::query();
        $perPage = $schoolsdata->count();
        $currentPage = $request->input('page', 1);
        $schools = $schoolsdata->skip($start)->take($rowPerPage);
        $schools = $schoolsdata->orderBy($columnsName, $columSortOrder);
        $i = 1;
        foreach ($schools as $school) {

            ini_set('memory_limit', '1028M');
            $datas[] = [
                'num' => $i++,
                'id' => $school->school_id,
                'code' => $school->school_code,
                'school_name' => $school->school_name,



            ];
            $total = count($datas);
            $allschool = [
                'draw' => intval($draw),
                'recordsTotal' => $total,
                'datas' => $datas,
            ];
        }
        return response()->json(['allschool' => $allschool]);
    }

    public function getSchools(Request $request)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 300);
        ini_set('pcre.backtrack_limit', 5000000);

        $query = School::query();

        $i = 1;

        $perPage = $request->input('length', 10); 
        $currentPage = $request->input('start', 0) / $perPage + 1;
        return DataTables::eloquent($query)
            ->addColumn('num', function () use (&$i, $currentPage, $perPage) {
                return $i++ + ($currentPage - 1) * $perPage;
            })
            ->addColumn('id', function ($school) {
                return $school->school_id;
            })
            ->addColumn('name_in_thai', function ($school) {
                $name_in_thai = Provinces::where('code', $school->provinces_code)
                    ->pluck('name_in_thai')
                    ->first();

                return $name_in_thai;
            })
            ->addColumn('scount', function ($school) {
                $UserSchoolcount = UserSchool::where('school_code', $school->school_code)
                    ->count();
                return $UserSchoolcount;
            })
            ->addColumn('school_name', function ($school) {


                return $school->school_name;
            })
            ->addColumn('code', function ($school) {


                return $school->school_code;
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('myInput') && !empty($request->myInput)) {
                    $query->where('school_name', 'like', '%' . $request->myInput . '%');
                }
            })
            ->filterColumn('name_in_thai', function ($query) use ($request) {
 
                if ($request->drop2 != '0') {
                        $query->where('provinces_code', $request->drop2);
             
                }
            })
    
            ->make(true);
    }

    public function create()
    {
        $depart = Department::all();
        return view('page.UserAdmin.group.umsschool.create', compact('depart'));
    }

    public function store(Request $request)
    {
        $school = new School;
        $school->school_name = $request->school_name;
        $school->provinces_id = $request->province_id;
        $school->subdistrict_id = null;
        $school->district_id = null;
        $school->department_id = $request->department_id;
        $school->save();
        return redirect()->route('schoolManage')->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
    }
    public function edit($school_id)
    {
        $school = School::findOrFail($school_id);
        $depart = Department::all();
        return view('page.UserAdmin.group.umsschool.edit', ['school' => $school, 'depart' => $depart]);
    }

    public function update(Request $request, $school_id)
    {
        $school = School::findOrFail($school_id);
        $school->school_name = $request->school_name;
        $school->provinces_code = $request->code;

        $school->department_id = $request->department_id;
        $school->save();
        return redirect()->route('schoolManage')->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
    }
    public function delete($school_id)
    {
        $school = School::findOrFail($school_id);
        $school->delete();


        return redirect()->back()->with('message', 'school ลบข้อมูลสำเร็จ');
    }
    public function adduser($school_code)
    {
        $school = School::findOrFail($school_code);
        $userschool = $school->userScho()->where('school_code', $school->school_code)->get();
        $users = Users::all();


        return view('page.UserAdmin.group.umsschool.item.adduserschool', ['school' => $school, 'userschool' => $userschool, 'users' => $users]);
    }

    public function saveSelectedSchool(Request $request, $school_code)

    {
        $school = School::findOrFail($school_code);
        $userDataString = $request->user_data;
        foreach ($userDataString as $userId) {
            DB::table('user_school')->insert([
                'school_code' => $school->school_code,
                'user_id' => $userId,

            ]);
        }

        return redirect()->back()->with('message', 'การบันทึก');
    }
}
