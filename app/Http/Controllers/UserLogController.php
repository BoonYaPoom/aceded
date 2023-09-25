<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    public function logusers($user_id){
        $users = Users::findOrFail($user_id);
        $logss = $users ->loguser()->where('user_id', $user_id)->get(); 
     return view('page.UserAdmin.group.umsloguser.index' ,compact('users', 'logss'));
    }
}
