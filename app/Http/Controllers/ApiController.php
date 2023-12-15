<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function apiDepartment()
    {
        $this->middleware('auth:api');
        $departapi = Department::all();
        return response()->json($departapi);
    }
    public function apiUser(Request $request)
    {
        $pageNumber = ($request->length != 0) ? ($request->start / $request->length) + 1 : 1;
        $pageLength = $request->length;
        $skip = ($pageNumber - 1) * $pageLength;


        $query = DB::table('users');
        $recordTotal = $recordsFiltered = $query->count();
        $usersapi = $query->take($pageLength)->skip($skip)->get();


        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $recordTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $usersapi,
        ], 200);
    }
}
