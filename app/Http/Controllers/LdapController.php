<?php

namespace App\Http\Controllers;

use App\Ldap\MyLdapModel; // เรียกใช้งาน LDAP Model ของคุณ
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Reader;

class LdapController extends Controller
{
    
    public function uploadForm()
    {
        return view('ldap.index');
    }

    public function uploadSql(Request $request)
    {
  
    }
}
