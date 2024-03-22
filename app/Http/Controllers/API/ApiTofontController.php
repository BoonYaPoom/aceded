<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTofontController extends Controller
{
    function provinces(Request $request)
    {

        $provinces = DB::table('provinces');
        $data = [];
        $lang = $request->input('lang');
        if ($provinces->count() >= 1) {
            foreach ($provinces->get() as $row) {
                $provinces_name = $lang == 'en' ? $row->name_in_english : ($lang == 'th' ? $row->name_in_thai : null);
                $data[] = [
                    'provinces_id' => $row->id,
                    'provinces_name' => $provinces_name ?? null
                ];
            }
        }

        return response()->json([
            'result' => 1,
            'total' => count($data),
            'data' => $data,
        ], 200);

    }
    function districts(Request $request)
    {
        $lang = $request->input('lang');
        $province = $request->input('province');
        $districts = DB::table('districts')->where('province_id', '=', $province);
        $data = [];
        if ($districts->count() >= 1) {
            foreach ($districts->get() as $row) {
                $districts_name = $lang == 'en' ? $row->name_in_english : ($lang == 'th' ? $row->name_in_thai : null);
                $data[] = [
                    'districts_id' => $row->id,
                    'districts_name' => $districts_name ?? null
                ];
            }
        }

        return response()->json([
            'result' => 1,
            'total' => count($data),
            'data' => $data,
        ], 200);

    }
    function subdistricts(Request $request)
    {

        $lang = $request->input('lang');
        $district = $request->input('district');
        $subdistricts = DB::table('subdistricts')->where('district_id', '=', $district);
        $data = [];
 
        if ($subdistricts->count() >= 1) {
            foreach ($subdistricts->get() as $row) {
                $subdistricts_name = $lang == 'en' ? $row->name_in_english : ($lang == 'th' ? $row->name_in_thai : null);
                $data[] = [
                    'subdistricts_id' => $row->id,
                    'subdistricts_name' => $subdistricts_name ?? null
                ];
            }
        }

        return response()->json([
            'result' => 1,
            'total' => count($data),
            'data' => $data,
        ], 200);

    }
}
