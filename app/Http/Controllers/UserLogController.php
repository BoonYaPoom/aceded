<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Signature;
use App\Models\Users;
use Illuminate\Http\Request;
use Throwable;

class UserLogController extends Controller
{
    public function logusers($user_id)
    {
        $users = Users::findOrFail($user_id);
        $logss = $users->loguser()->where('user_id', $user_id)->get();
        return view('page.UserAdmin.group.umsloguser.index', compact('users', 'logss'));
    }
    public function error500()
    {

        return response()->view('error.error-500', [], 500);
    }
    public function signaturereport(Request $request)
    {



        $sig = new Signature;
        $sig->user_id1 = $request->user_id1;
        $sig->user_id2 = $request->user_id2;
        $sig->user_id3 = $request->user_id3;
        $sig->user_id4 = $request->user_id4;
        $sig->save();

        return response()->view('error.error-500', [], 500);
    }

    public function logusersDP($department_id, $user_id)
    {
        $users = Users::findOrFail($user_id);


        $logss = $users->loguser()->where('user_id', $user_id)->get();


        $depart = Department::findOrFail($department_id);


        return view('layouts.department.item.data.UserAdmin.group.umsloguser.index', compact('users', 'logss', 'depart'));
    }
}
