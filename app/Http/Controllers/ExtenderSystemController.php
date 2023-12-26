<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Extender2;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ExtenderSystemController extends Controller
{

    public function testumsschool()
    {
        set_time_limit(0);
        $extendernull = DB::table('users_extender2')->where('item_group_id', null)->get();
        $extender1 = DB::table('users_extender2')->where('item_group_id', 1)->get();
        $extender2 = DB::table('users_extender2')->where('item_group_id', 2)->get();
        $extender3 = DB::table('users_extender2')->where('item_group_id', 3)->get();
        $extender4 = DB::table('users_extender2')->where('item_group_id', 4)->get();
        $extender5 = DB::table('users_extender2')->where('item_group_id', 5)->get(); 

        return view('layouts.department.item.data.UserAdmin.group.umsschool.test.index', compact('extender'));
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
