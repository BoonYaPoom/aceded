<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Extender2;
use App\Models\Provinces;
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
        $depart = Department::findOrFail($department_id);

        return view('layouts.department.item.data.UserAdmin.group.umsschool.test.dep', compact('depart'));
    }
    public function testumsschool($department_id)
    {
        set_time_limit(0);
        $depart = Department::findOrFail($department_id);

        return view('layouts.department.item.data.UserAdmin.group.umsschool.test.index', compact('depart'));
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

    public function addextendersubmit(Request $request, $department_id)
    {
        $depart = Department::findOrFail($department_id);
        $maxUserextendertId = DB::table('users_extender2')->max('extender_id');
        DB::table('users_extender2')->insert([
            'extender_id' =>  $maxUserextendertId + 1,
            'name' => $request->school_name,
            'item_group_id' => 1,
            'item_parent_id' => $request->extender_id,
        ]);

        return redirect()->route('testumsschool', $depart)->with('message', 'การบันทึก');
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
            $data = DB::table('users')->where('user_id', Session::get('loginId'))->first();
            $orgs = $data->organization;
            $query = DB::table('users_extender2');
            if ($data->user_role == 1 || $data->user_role == 8 || $data->user_role == 7) {
                switch ($department_id) {
                    case 1:
                    case 2:
                    case 3:
                        $query->join('provinces', function ($join) {
                            $join->on('users_extender2.name', 'like', DB::raw(" '%' || provinces.name_in_thai || '%' "));
                        })
                            ->where('users_extender2.item_lv', 4)
                            ->where('users_extender2.item_group_id', 1)
                            ->select('provinces.*', 'users_extender2.*')
                            ->get();
                        break;
                    case 4:
                    case 5:
                        $query->join('provinces', function ($join) {
                            $join->on('users_extender2.name', 'like', DB::raw(" '%' || provinces.name_in_thai || '%' "));
                        })
                            ->where('users_extender2.item_group_id', 2)
                            ->select('provinces.*', 'users_extender2.*')
                            ->get();
                        break;
                    case 6:
                        $query->join('provinces', function ($join) {
                            $join->on('users_extender2.name', 'like', DB::raw(" '%' || provinces.name_in_thai || '%' "));
                        })
                            ->where('users_extender2.item_lv', 3)
                            ->whereIn('users_extender2.item_group_id', [3, 4])
                            ->select('provinces.*', 'users_extender2.*')
                            ->get();
                        break;
                    default:
                        break;
                }
            } elseif ($data->user_role == 6 || $data->user_role == 3) {
                switch ($department_id) {
                    case 1:
                    case 2:
                    case 3:
                        $query->where('extender_id', $orgs);
                        break;
                    case 4:
                    case 5:
                        $query->where('extender_id', $orgs);
                        break;
                    case 6:
                        $query->where('extender_id', $orgs);

                        break;
                    default:
                        break;
                }
            }
        } else {
            $query = DB::table('users_extender2')->get();
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

            ->addColumn('name_in_thai', function ($extender) {
                return $extender->name_in_thai;
            })
            // ->addColumn('count', function ($extender) use ($department_id) {
            //     $userDepart = DB::table('users_department')->where('department_id', $department_id)->pluck('user_id');
            //     $UserSchoolcount =
            //         DB::table('users')->whereIn('user_id', $userDepart)
            //         ->where('organization', $extender->extender_id)
            //         ->count();

            //     return $UserSchoolcount;
            // })
            ->addColumn('parentExtender', function ($extender) {

                $parentExtender =
                    DB::table('users_extender2')->where('extender_id', $extender->item_parent_id)->first();
                if ($parentExtender) {
                    return $parentExtender->name;
                }
                return '-';
            })
            ->filter(function ($extender) use ($request) {
                if ($request->has('myInput') && !empty($request->myInput)) {
                $extender->where('name', 'like', '%' . $request->myInput . '%');
                }
            })
            ->filterColumn('name_in_thai', function ($extender) use ($request) {

                if ($request->drop2 != '0') {
                $extender->where('name', 'like', '%' . $request->drop2 . '%');
                }
            })
            ->toJson();
    }
    public function getUserCount(Request $request, $department_id)
    {
        $depart = Department::findOrFail($department_id);
        $extenderId = $request->input('extender_id');

        $userDepart = DB::table('users_department')->where('department_id', $department_id)->pluck('user_id');
        $userCount = DB::table('users')
            ->whereIn('user_id', $userDepart)
            ->where('organization', $extenderId)
            ->count();

        return response()->json(['count' => $userCount]);
    }


    public function testumsschool2($department_id)
    {
        set_time_limit(0);
        $depart = Department::findOrFail($department_id);
        $query = DB::table('users_extender2')
            ->join('provinces', 'provinces.name_in_thai', '=', 'users_extender2.name')
            ->orWhere('users_extender2.name', 'LIKE', '%ชลบุรี%')
            ->select('users_extender2.*')
            ->get();

        $provincesWithMatchingExtender = DB::table('users_extender2')
            ->join('provinces', function ($join) {
                $join->on('users_extender2.name', 'like', DB::raw(" '%' || provinces.name_in_thai || '%' "));
            })
            ->where('users_extender2.item_lv', 4)
            ->where('users_extender2.item_group_id', 1)
            ->select('provinces.*', 'users_extender2.*')
            ->get();

        dd($provincesWithMatchingExtender);
        return view('layouts.department.item.data.UserAdmin.group.umsschool.test2.index', compact('depart'));
    }


    public function getExtender3(Request $request, $department_id)
    {
        set_time_limit(0);
        if (Session::has('loginId')) {
            $data = DB::table('users')->where('user_id', Session::get('loginId'))->first();
            $orgs = $data->organization;
            $query = DB::table('users_extender2');
            if ($data->user_role == 1 || $data->user_role == 8 || $data->user_role == 7) {
                switch ($department_id) {
                    case 1:
                    case 2:
                    case 3:

                        $query->join('provinces', function ($join) {
                            $join->on('users_extender2.name', 'like', DB::raw(" '%' || provinces.name_in_thai || '%' "));
                        })
                            ->where('users_extender2.item_lv', 4)
                            ->where('users_extender2.item_group_id', 1)
                            ->select('provinces.*', 'users_extender2.*')
                            ->get();
                        break;
                    case 4:
                    case 5:
                        $query->join('provinces', function ($join) {
                            $join->on('users_extender2.name', 'like', DB::raw(" '%' || provinces.name_in_thai || '%' "));
                        })
                            ->where('users_extender2.item_group_id', 2)
                            ->select('provinces.*', 'users_extender2.*')
                            ->get();
                        break;
                    case 6:
                        $query->join('provinces', function ($join) {
                            $join->on('users_extender2.name', 'like', DB::raw(" '%' || provinces.name_in_thai || '%' "));
                        })
                            ->where('users_extender2.item_lv', 3)
                            ->whereIn('users_extender2.item_group_id', [3, 4])
                            ->select('provinces.*', 'users_extender2.*')
                            ->get();
                        break;
                    default:
                        break;
                }
            } elseif ($data->user_role == 6 || $data->user_role == 3) {
                switch ($department_id) {
                    case 1:
                    case 2:
                    case 3:
                        $query->where('extender_id', $orgs);
                        break;
                    case 4:
                    case 5:
                        $query->where('extender_id', $orgs);
                        break;
                    case 6:
                        $query->where('extender_id', $orgs);

                        break;
                    default:
                        break;
                }
            }
        } else {
            $query = DB::table('users_extender2')->get();
        }
        $i = 1;

        $perPage = $request->input('length', 10);
        // คำนวณหน้าปัจจุบัน
        $currentPage = $request->input('start', 0) / $perPage + 1;
    }
}
