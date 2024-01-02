<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Extender2;
use App\Models\School;
use App\Models\UserDepartment;
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
        $query = Extender2::query();
        return view('layouts.department.item.data.UserAdmin.group.umsschool.test.index', compact('extender', 'depart'));
    }
    public function adduser($department_id, $extender_id)
    {
        $extender = Extender2::findOrFail($extender_id);
        $depart = Department::findOrFail($department_id);
        $userDepart = DB::table('users_department')->where('department_id', $department_id)->pluck('user_id');
        $usersnotnull = collect(); // Initialize an empty collection


        if ($userDepart->isNotEmpty()) {
            $usersnotnull = DB::table('users')
                ->whereIn('user_id', $userDepart)
                ->where('organization', $extender_id)
                ->get();
        }
        $usersnull =
            DB::table('users')
            ->whereIn('user_id', $userDepart)
            ->where('organization', null)
            ->get();

        return view(
            'layouts.department.item.data.UserAdmin.group.umsschool.test.add.adduserschool',
            ['depart' => $depart, 'userDepart' => $userDepart, 'extender' => $extender, 'usersnull' => $usersnull, 'usersnotnull' => $usersnotnull]
        );
    }



    public function addextender($department_id,)
    {

        $depart = Department::findOrFail($department_id);
        $extendernull = DB::table('users_extender2')->where('item_parent_id', null)->get();
        $extender = DB::table('users_extender')->where('status', 1)->get();
        $extender_1 = DB::table('users_extender2')->where('item_group_id', 1)->get();
        $extender2 = DB::table('users_extender2')->get();
        $extender2Json = json_encode($extender2);
        $extender_1Json = json_encode($extender_1);

        return view(
            'layouts.department.item.data.UserAdmin.group.umsschool.test.create.add',
            compact('extender', 'depart', 'extender', 'extender_1Json', 'extender2', 'extender2Json', 'extendernull')
        );
    }


    public function saveExtender(Request $request, $department_id, $extender_id)

    {
        $extender = Extender2::findOrFail($extender_id);

        $userDataString = $request->user_data;
        foreach ($userDataString as $userId) {
            DB::table('users')->where(
                'user_id',
                $userId
            )  // ให้อัปเดตเฉพาะผู้ใช้ที่มี 'user_id' ตรงกับค่าใน $userId
                ->update([
                    'organization' => $extender->extender_id,
                ]);
        }

        return redirect()->back()->with('message', 'การบันทึก');
    }

    public function getExtender(Request $request, $department_id)
    {
        set_time_limit(0);
        if (Session::has('loginId')) {
            $data = Users::where('user_id', Session::get('loginId'))->first();
            $orgs = $data->organization;
            $query = Extender2::query();
            if ($data->user_role == 1 || $data->user_role == 8) {
                switch ($department_id) {
                    case 1:
                    case 2:
                    case 3:
                        $query->where('item_group_id', 1);
                        break;
                    case 4:
                    case 5:
                        $query->where('item_group_id', 2);
                        break;
                    case 6:
                        $query->whereIn('item_group_id', [3, 4]);
                        break;
                    default:
                        break;
                }
            } elseif ($data->user_role == 6 || $data->user_role == 7) {
                switch ($department_id) {
                    case 1:
                    case 2:
                    case 3:
                        $query->where('item_group_id', 1)->where('extender_id', $orgs);
                        break;
                    case 4:
                    case 5:
                        $query->where('item_group_id', 2)->where('extender_id', $orgs);
                        break;
                    case 6:
                        $query->whereIn('item_group_id', [3, 4])->where('extender_id', $orgs);

                        break;
                    default:
                        break;
                }
            }
        } else {

            $query = Extender2::query();
        }

        $i = 1;

        $perPage = $request->input('length', 10);
        // คำนวณหน้าปัจจุบัน
        $currentPage = $request->input('start', 0) / $perPage + 1;

        $paginatedQuery = $query->paginate($perPage);

        return DataTables::of($query)
            ->addColumn('num', function () use (&$i, $currentPage, $perPage) {
                return $i++ + ($currentPage - 1) * $perPage;
            })
            ->addColumn('EXTENDER_ID', function ($extender) {
                return $extender->extender_id;
            })
            ->addColumn('NAME', function ($extender) {
                return $extender->name;
            })
            ->addColumn('count', function ($extender) use ($department_id) {

                $userDepart = DB::table('users_department')->where('department_id', $department_id)->pluck('user_id');

                $UserSchoolcount = Users::whereIn('user_id', $userDepart)
                    ->where('organization', $extender->extender_id)
                    ->count();

                return $UserSchoolcount;
            })
            ->addColumn('parentExtender', function ($extender) {

                $parentExtender = Extender2::where('extender_id', $extender->item_parent_id)->first();
                if ($parentExtender) {
                    return $parentExtender->name;
                }
                return '-';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('myInput') && !empty($request->myInput)) {
                    $query->where('name', 'like', '%' . $request->myInput . '%');
                    // Add more conditions with orWhere if needed
                }
            })
            ->toJson();
    }
}
