<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class RolemanageController extends Controller
{
    public function RoleTypes()
    {
        $count5 = Users::where('user_role',5)->count();
        $count3 = Users::where('user_role', 3)->count();
        $count4 = Users::where('user_role', 4)->count();
        $role5 = Users::where('user_role',5)->get();
        $role3 = Users::where('user_role', 3)->get();
        $role4 = Users::where('user_role', 4)->get();
        return view('page.UserAdmin.group.umsrole.manageRole', compact('count5', 'count3', 'count4', 'role5', 'role3', 'role4'));
    }
      public function pageperson($user_role){
        $usermanages = Users::query();
    
        if ($user_role !== null) {
            $usermanages->where('user_role', $user_role);
        }
    
        $usermanages = $usermanages->get();
        return view('page.UserAdmin.group.umsgroup.groupuser.create', compact('users'));
    }
    
    public function updateusertype(Request $request,$person_type){
        $users = Users::findOrFail($person_type);
        
    
    return redirect()->back()->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
}
}
