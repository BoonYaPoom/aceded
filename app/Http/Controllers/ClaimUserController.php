<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimUserController extends Controller
{

    public function Certanddepart()
    {
        set_time_limit(0);
        $claimuser = DB::table('department_claim')->get();
        $cert_file = DB::table('certificate_file')->get();
        return view(
            'layouts.department.item.data.request.CerAndDepart.index',
            ['cert_file' => $cert_file, 'claimuser' => $claimuser]
        );
    }
}
