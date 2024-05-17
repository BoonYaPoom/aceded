<?php

namespace App\Http\Controllers\ExtenDepart;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ExtenderDepartController extends Controller
{
    public function extenindex($department_id)
    {
        $depart = Department::findOrFail($department_id);

        return view('layouts.department.item.data.UserAdmin.group.umsschool.test.department6.index', compact('depart'));
    }
    public function getExtender(Request $request, $department_id)
    {
        set_time_limit(0);
        ini_set('memory_limit', '4G');
        if (Session::has('loginId')) {
            $data = DB::table('users')->where('user_id', Session::get('loginId'))->first();
            $orgs = $data->organization;

            $provins = $data->province_id;

            $query = DB::table('users_extender2');
            if ($data->user_role == 1 || $data->user_role == 8) {
                switch ($department_id) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                        $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->whereIn('users_extender2.item_lv', [2, 3, 4])
                            ->where('users_extender2.item_group_id', 1)
                            ->select('provinces.*', 'users_extender2.*')
                            ->get();
                        break;

                    case 5:
                        $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->where('users_extender2.item_group_id', 2)
                        ->select('provinces.*', 'users_extender2.*')
                        ->get();
                        break;
                    case 6:
                        $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->whereIn('users_extender2.item_lv', [3, 4])
                            ->whereIn('users_extender2.item_group_id', [3, 4])
                            ->select('provinces.*', 'users_extender2.*')
                            ->get();
                        break;
                    default:
                        break;
                }
            } elseif ($data->user_role == 7) {
                switch ($department_id) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                        $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->where('provinces.id',  $provins)
                            ->select('provinces.*', 'users_extender2.*');
                        break;
                    case 5:
                        $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->where('provinces.id',  $provins)->select('provinces.*', 'users_extender2.*');
                        break;
                    case 6:
                        $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                        ->where('provinces.id',  $provins)->select('provinces.*', 'users_extender2.*');
                        break;
                    default:
                        break;
                }
            } elseif ($data->user_role == 6 || $data->user_role == 3) {
                switch ($department_id) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                        $query->where('extender_id', $orgs)->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->select('provinces.*', 'users_extender2.*');
                        break;

                    case 5:
                        $query->where('extender_id', $orgs)->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->select('provinces.*', 'users_extender2.*');
                        break;
                    case 6:
                        $query->where('extender_id', $orgs)
                            ->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')
                            ->select('provinces.*', 'users_extender2.*');

                        break;
                    default:
                        break;
                }
            } elseif ($data->user_role == 9) {
                $zones = DB::table('user_admin_zone')->where('user_id', $data->user_id)->pluck('province_id')->toArray();

                switch ($department_id) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                        $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->whereIn('users_extender2.school_province',  $zones)->select('provinces.*', 'users_extender2.*');
                        break;
                    case 5:
                        $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->whereIn('users_extender2.school_province',  $zones)->select('provinces.*', 'users_extender2.*');
                        break;
                    case 6:
                        $query->join('provinces', 'users_extender2.school_province', '=', 'provinces.id')->whereIn('users_extender2.school_province',  $zones)->select('provinces.*', 'users_extender2.*');
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
            ->addColumn('count', function ($extender) use ($department_id) {

                $UserSchoolcount =
                    DB::table('users')->join('users_department', 'users.user_id', '=', 'users_department.user_id')
                    ->where('users_department.department_id', '=', $department_id)
                    ->where('organization', $extender->extender_id)
                    ->count();

                return $UserSchoolcount;
            })
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
                    $extender->where('name_in_thai', 'like', '%' . $request->drop2 . '%');
                }
            })
            ->toJson();
    }
}
