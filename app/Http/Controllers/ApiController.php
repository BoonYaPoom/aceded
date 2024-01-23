<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function apiDepartment(){
        $this->middleware('auth:api');
        $departapi = Department::all();
        return response()->json($departapi);
    }
    public function uploadImage(Request $request)
    {
        header('Access-Control-Allow-Origin: *');

        $imageName = $request->input('imageName');
        $imageData = $request->input('imageData');
        $imageData = base64_decode($imageData);

        $uploadPath = '/upload/certificate/' . $imageName;
        Storage::put($uploadPath, $imageData);

        $response = ['success' => true];
        return response()->json($response);
    }


    public function apiUsers(){
        $usersApi = DB::table('users')->select('user_id','username','password','firstname','lastname')->get();

        return response()->json($usersApi);
    }
    
}
