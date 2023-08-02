<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    public function logusers($uid){
        $users = Users::findOrFail($uid);
        $logss = $users ->loguser()->where('uid', $uid)->get(); 
     return view('page.UserAdmin.group.umsloguser.index' ,compact('users', 'logss'));
    }
}
