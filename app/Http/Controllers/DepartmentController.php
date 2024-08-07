<?php

namespace App\Http\Controllers;

use App\Models\ActivityCategory;
use App\Models\Department;
use App\Models\General;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function bookif()
    {

        return view('book.index');
    }
    public function aced()
    {
        $department  = Department::all();
        $from = 'lms';
        return view('nolog.aced',  compact('department'));
    }
    public function departmentLearnpage()
    {
        $department  = Department::all();
        $from = 'lms';
        return view('layouts.department.item.departmentLearn',  compact('department', 'from'));
    }
    public function departmentdlspage()
    {
        $department  = Department::all();
        $from = 'dls';
        return view('layouts.department.item.departmentdls',  compact('department', 'from'));
    }
    public function departmentwmspage()
    {

        $department  = Department::all();
        $from = 'wms';
        return view('layouts.department.item.departmentwms', compact('department', 'from'));
    }
    public function departmentums()
    {
        $department  = Department::all();
        $from = 'ums';
        return view('layouts.department.item.departmentums', compact('department', 'from'));
    }
    public function departmentcreate($from)
    {
        $departmentLink = '';

        if ($from === 'lms') {
            $departmentLink = route('departmentLearnpage');
        } elseif ($from === 'dls') {
            $departmentLink = route('departmentdlspage');
        } elseif ($from === 'wms') {
            $departmentLink = route('departmentwmspage');
        } elseif ($from === 'ums') {
            $departmentLink = route('departmentumspage');
        }

        return view('layouts.department.create', compact('departmentLink', 'from'));
    }
    public function store(Request $request)
    {

        $request->validate([

            'name_short_en' => 'required|unique:department',
        
        ]);
        try {

            $depart = new Department;
            $depart->name_th = $request->name_th;
            $depart->name_en = $request->name_en;

            $depart->name_short_en = $request->name_short_en;
            $depart->department_id_ref = $request->department_id_ref;
            $depart->department_status = $request->input('department_status', 0);
            if ($request->hasFile('name_short_th')) {
                $image = $request->file('name_short_th');
                $imageName =  $image->getClientOriginalName();
                // $image->move(public_path('upload/Department/'), $imageName);
               
                $uploadDirectory = 'Department/';
                if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                    Storage::disk('sftp')->makeDirectory($uploadDirectory);
                }
                if (Storage::disk('sftp')->exists($uploadDirectory)) {
                    // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                    Storage::disk('sftp')->delete($uploadDirectory);
                    Storage::disk('sftp')->put($uploadDirectory . '/' . $imageName, file_get_contents($request->name_short_th->getRealPath()));
                    $depart->name_short_th = 'upload/Department/' . $imageName;

                }
            }


            $depart->color = $request->color;
            $depart->save();

            $actcat = new ActivityCategory;
            $actcat->category_th = 'ห้องถ่ายทอดสด';
            $actcat->category_en = 'Live Streaming';
            $actcat->detail_th = '';
            $actcat->detail_en = '';
            $actcat->department_id = $depart->department_id;
            $actcat->category_date = now();
            $actcat->category_update = null;
            $actcat->category_type = 1;
            $actcat->category_status = 0;
            $actcat->category_option = null;
            $actcat->recommended = '0';
            $actcat->cover = '';

          
            $actcat = new ActivityCategory;
            $actcat->category_th = 'ห้องประชุม';
            $actcat->category_en = 'Meeting Room';
            $actcat->detail_th = '';
            $actcat->detail_en = '';
            $actcat->department_id = $depart->department_id;
            $actcat->category_date = now();
            $actcat->category_update = null;
            $actcat->category_type = 2;
            $actcat->category_status = 0;
            $actcat->category_option = null;
            $actcat->recommended = '0';
            $actcat->cover = '';

            $actcat->save();
         

            $genaral = new General;
            if ($request->hasFile('detail')) {

                $filename = 'logo' . $depart->department_id . '.' . $request->detail->getClientOriginalExtension();
                // $uploadDirectory = public_path('upload/LOGO/');
                // if (!file_exists($uploadDirectory)) {
                //     mkdir($uploadDirectory, 0755, true);
                // }
                // if (file_exists($uploadDirectory)) {

                //     file_put_contents(public_path('upload/LOGO/' . $filename), file_get_contents($request->detail));
                //     $genaral->detail = 'upload/LOGO/' . 'logo' . $depart->department_id . '.' . $request->detail->getClientOriginalExtension();
                // }
                // อัปเดตข้อมูลในตาราง 'General'
                $uploadDirectory = 'LOGO/';
                if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                    Storage::disk('sftp')->makeDirectory($uploadDirectory);
                }
                if (Storage::disk('sftp')->exists($uploadDirectory)) {
                    // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                    Storage::disk('sftp')->delete($uploadDirectory);
                    Storage::disk('sftp')->put($uploadDirectory . '/' . $filename, file_get_contents($request->detail->getRealPath()));
                    $genaral->path = 'upload/LOGO/' . 'logo' . $depart->department_id . '.' . $request->detail->getClientOriginalExtension();
               
                }
                $genaral->title = 'logo';
                $genaral->status = 1;
                $genaral->department_id =  $depart->department_id;
            }
            $genaral->save();
            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->view('error.error-500', [], 500);
        }
        $from = request('from');
        if ($from === 'lms') {

            return redirect()->route('departmentLearnpage')->with('message', 'success Department control');
        } elseif ($from === 'dls') {

            return redirect()->route('departmentdlspage')->with('message', 'success Department control');
        } elseif ($from === 'wms') {

            return redirect()->route('departmentwmspage')->with('message', 'success Department control');
        } elseif ($from === 'ums') {

            return redirect()->route('departmentumspage')->with('message', 'success Department control');
        }
    }
    public function departmentedit($from, $department_id)
    {
        #$depart = Department::where('name_short_en', $name_short_en)->firstOrFail();
        $depart  = Department::findOrFail($department_id);
        $departmentLink = '';

        if ($from === 'lms') {
            $departmentLink = route('departmentLearnpage');
        } elseif ($from === 'dls') {
            $departmentLink = route('departmentdlspage');
        } elseif ($from === 'wms') {
            $departmentLink = route('departmentwmspage');
        } elseif ($from === 'ums') {
            $departmentLink = route('departmentumspage');
        }
        return view('layouts.department.edit', compact('depart', 'from', 'departmentLink'));
    }
    public function homede($department_id)
    {

        $depart  = Department::findOrFail($department_id);

        return view('layouts.department.item.data.home', compact('depart'));
    }
    public function update(Request $request, $from, $department_id)
    {

        $depart =  Department::findOrFail($department_id);
        $depart->name_th = $request->name_th;
        $depart->name_en = $request->name_en;


        $depart->department_id_ref = $request->department_id_ref;
        $depart->department_status = $request->input('department_status', 0);
        if ($request->hasFile('name_short_th')) {
            $image = $request->file('name_short_th');
            $imageName =  $image->getClientOriginalName();
            // $image->move(public_path('upload/Department/'), $imageName);
            $uploadDirectory = 'Department/';
            if (!Storage::disk('sftp')->exists($uploadDirectory)) {
                Storage::disk('sftp')->makeDirectory($uploadDirectory);
            }
            if (Storage::disk('sftp')->exists($uploadDirectory)) {
                // ตรวจสอบว่ามีไฟล์เดิมอยู่หรือไม่ ถ้ามีให้ลบออก
                Storage::disk('sftp')->delete($uploadDirectory);
                Storage::disk('sftp')->put($uploadDirectory . '/' . $imageName, file_get_contents($request->name_short_th->getRealPath()));
            
            }
            $depart->name_short_th = 'upload/Department/' . $imageName;
        }
        $depart->color = $request->color;
        $depart->save();


        if ($from === 'lms') {

            return redirect()->route('departmentLearnpage')->with('message', 'success Department control');
        } elseif ($from === 'dls') {

            return redirect()->route('departmentdlspage')->with('message', 'success Department control');
        } elseif ($from === 'wms') {

            return redirect()->route('departmentwmspage')->with('message', 'success Department control');
        } elseif ($from === 'ums') {

            return redirect()->route('departmentumspage')->with('message', 'success Department control');
        }
    }

    public function changeStatus(Request $request)
    {
        $Depart = Department::find($request->department_id);

        if ($Depart) {
            $Depart->department_status = $request->department_status;
            $Depart->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล web']);
        }
    }

    public function destroy($department_id)
    {
        $Depart = Department::findOrFail($department_id);

        $Depart->delete();
        return redirect()->back()->with('message', 'Department ลบข้อมูลสำเร็จ');
    }


}
