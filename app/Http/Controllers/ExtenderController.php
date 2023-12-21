<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Extender2;
use App\Models\School;
use App\Models\Users;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExtenderController extends Controller
{
    public function testumsschooldepartment($department_id)
    {

        if (Session::has('loginId')) {
            $school = [];
            $data = Users::where('user_id', Session::get('loginId'))->first();
            $depart = Department::findOrFail($department_id);
            $users  = $depart->UserDe()->where('department_id', $department_id);
            $extender = DB::table('user_extender2')->get();    
            if ($data->user_role == 1 || $data->user_role == 8) {
            } elseif ($data->user_role == 6 || $data->user_role == 7) {
            }
        }
        return view('layouts.department.item.data.UserAdmin.group.umsschool.test.dep', compact('depart', 'users', 'school', 'userschool'));
    }
    public function testumsschool($department_id)
    {
        set_time_limit(0);
        $depart = Department::findOrFail($department_id);
        $extender = DB::table('users_extender2')->get();

        return view('layouts.department.item.data.UserAdmin.group.umsschool.test.index',compact('extender', 'depart'));
    }
    public function adduser($department_id, $extender_id)
    {
        $extender = Extender2::findOrFail($extender_id);
        $depart = Department::findOrFail($department_id);
        $users = $depart->UserDe()->where('department_id', $department_id)->get();
        $usersnull = $users->where('organization', null);

        return view('layouts.department.item.data.UserAdmin.group.umsschool.test.add.adduserschool', ['depart' => $depart, 'users' => $users  , 'extender', $extender]);
    }

    public function getExtender(Request $request)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 300);
        ini_set('pcre.backtrack_limit', 5000000);

        if (Session::has('loginId')) {
            $data = Users::where('user_id', Session::get('loginId'))->first();
            $orgs = $data->organization;

            if ($data->user_role == 1 || $data->user_role == 8) {
                $query = Extender2::where('ITEM_GROUP_ID', 1);
            } elseif ($data->user_role == 6 || $data->user_role == 7) {
        
                $query = Extender2::where('ITEM_GROUP_ID', 1)
                    ->where('extender_id', $orgs);
            }
        } else {

            $query = Extender2::query();
        }

        $i = 1;
      
        $perPage = $request->input('length', 10);
        $currentPage = $request->input('start', 0) / $perPage + 1;


        return DataTables::eloquent($query)
            ->addColumn('num', function () use (&$i, $currentPage, $perPage) {
                return $i++ + ($currentPage - 1) * $perPage;
            })
            ->addColumn('EXTENDER_ID', function ($extender) {
                return $extender->EXTENDER_ID;
            })
            ->addColumn('NAME', function ($extender) {
                return $extender->NAME;
            })
            ->addColumn('count', function ($extender) {

            // $UserSchoolcount = DB::table('users')->where('organization', $extender->EXTENDER_ID)
            //     ->count();
            $UserSchoolcount =  Users::where('organization', $extender->EXTENDER_ID)
                ->count();
                return $UserSchoolcount;
            })
            ->addColumn('parentExtender', function ($extender) {

            $parentExtender = Extender2::where('EXTENDER_ID', $extender->ITEM_PARENT_ID)->first();
            if ($parentExtender) {
                return $parentExtender->NAME;
            }
            return 'N/A';

            })
            ->make(true);
    }
}
