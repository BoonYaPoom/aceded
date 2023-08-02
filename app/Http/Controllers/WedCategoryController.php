<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\WebCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class WedCategoryController extends Controller
{
           public function evenpage(){
            $wed=WebCategory::all();
        return view('page.manages.even.evens',compact('wed'));
           }
           public function create(){
        return view('page.manages.even.create');
           }
           public function store(Request $request){
            $request->validate([
                'category_th' => 'required'
        
            ]);
                    $wed = new WebCategory;
                    if ($request->hasFile('cover')) {
                    
                        $file_name = time() . '.' . $request->cover->getClientOriginalExtension();
                        Storage::disk('external')->put('webcategory/' . $file_name, file_get_contents($request->cover));
                
                    } else {
                        $file_name = '';
                    }
                    $wed->cover = $file_name;
                    $wed->category_th=$request->category_th;
                    $wed->category_en=$request->category_en;
                    $wed->detail_th='';
                    $wed->detail_en='';
                    $wed->category_date = now();
                    $wed->category_status = $request->input('category_status', 0);
                    $wed->category_type = '';
                    $wed->category_option = '';
                    $wed->recommended = 1;
                    $wed->save();



                    if(Session::has('loginId')){
                        $loginId = Session::get('loginId');
                     
                        $userAgent = $request->header('User-Agent');
                
                     
                    }
                    $conditions = [
                        'Windows' => 'Windows',
                        'Mac' => 'Macintosh|Mac OS',
                        'Linux' => 'Linux',
                        'Android' => 'Android',
                        'iOS' => 'iPhone|iPad|iPod',
                    ];
                    
                    $os = '';
                    
                    // Loop through the conditions and check the user agent for the operating system
                    foreach ($conditions as $osName => $pattern) {
                        if (preg_match("/$pattern/i", $userAgent)) {
                            $os = $osName;
                            break; // Exit the loop once a match is found
                        }
                    }
                    if (preg_match('/(Chrome|Firefox|Safari|Opera|Edge|IE|Edg)[\/\s](\d+\.\d+)/i', $userAgent, $matches)) {
                        $browser = $matches[1];
                        
                    }
            
                    
                    if ($loginId) {
                        $loginLog = Log::where('uid', $loginId)->where('logaction', 2)->first();
                        
                   
                        $loginLog = new Log;
                        $loginLog->logid = 2;
                        $loginLog->logaction = 2;
                        $loginLog->logdetail = '';
                        $loginLog->idref  = 1;
                        $loginLog->subject_id  = 1;
                        $loginLog->duration = 1;
                        $loginLog->status  = 0;
                        $loginLog->uid = $loginId;
                        $loginLog->logagents = $browser;
                        $loginLog->logip = $request->ip();
            
                        $loginLog->logdate = now()->format('Y-m-d H:i:s');
                        $loginLog->logplatform = $os;
                        
                    
                        }
            
                    
                    $loginLog->save();
            

                    return redirect()->route('evenpage')->with('message', 'Data saved successfully');

           }
           public function edit($category_id) {
            $wed = WebCategory::findOrFail($category_id);
            return view('page.manages.even.edit', ['wed' => $wed]);
        }

        public function update(Request $request , $category_id){
            $request->validate([
                'category_th' => 'required'
        
            ]);
            $wed = WebCategory::findOrFail($category_id);
        
            if ($request->hasFile('cover')) {
                $file_name = time() . '.' . $request->cover->getClientOriginalExtension();
                if (Storage::disk('external')->exists('webcategory/' . $file_name)) {
                    Storage::disk('external')->delete('webcategory/' . $file_name);
                }
                
                Storage::disk('external')->put('webcategory/' . $file_name, file_get_contents($request->cover));
                    } else {
                $file_name = '';
            }
           $wed->cover = $file_name;
            $wed->category_th=$request->category_th;
            $wed->category_en=$request->category_en;
            $wed->detail_th='';
            $wed->detail_en='';
            $wed->category_update = now();
            $wed->category_status = 1;
            $wed->category_type = '';
            $wed->category_option = '';
            $wed->recommended = 1;
            $wed->save();

            if(Session::has('loginId')){
                $loginId = Session::get('loginId');
             
                $userAgent = $request->header('User-Agent');
        
             
            }
            $conditions = [
                'Windows' => 'Windows',
                'Mac' => 'Macintosh|Mac OS',
                'Linux' => 'Linux',
                'Android' => 'Android',
                'iOS' => 'iPhone|iPad|iPod',
            ];
            
            $os = '';
            
            // Loop through the conditions and check the user agent for the operating system
            foreach ($conditions as $osName => $pattern) {
                if (preg_match("/$pattern/i", $userAgent)) {
                    $os = $osName;
                    break; // Exit the loop once a match is found
                }
            }
            if (preg_match('/(Chrome|Firefox|Safari|Opera|Edge|IE|Edg)[\/\s](\d+\.\d+)/i', $userAgent, $matches)) {
                $browser = $matches[1];
                
            }
    
            
            if ($loginId) {
                $loginLog = Log::where('uid', $loginId)->where('logaction', 3)->first();
                
           
                $loginLog = new Log;
                $loginLog->logid = 2;
                $loginLog->logaction = 3;
                $loginLog->logdetail = '';
                $loginLog->idref  = 1;
                $loginLog->subject_id  = 1;
                $loginLog->duration = 1;
                $loginLog->status  = 0;
                $loginLog->uid = $loginId;
                $loginLog->logagents = $browser;
                $loginLog->logip = $request->ip();
    
                $loginLog->logdate = now()->format('Y-m-d H:i:s');
                $loginLog->logplatform = $os;
                
            
                }
    
            
            $loginLog->save();
    
            return redirect()->route('evenpage')->with('warning', 'Data update successfully');



        }

        public function destroy($category_id){
            $wed = WebCategory::findOrFail($category_id);

            $wed->delete();

            
            
            return redirect()->route('evenpage')->with('message', 'Data destroy successfully');
        }
        public function changeStatus(Request $request){
            $wed = WebCategory::find($request->category_id);

            if ($wed) {
                $wed->category_status = $request->category_status;
                $wed->save();
              
                return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
            } else {
                return response()->json(['message' => 'ไม่พบข้อมูล wed']);
            }
        }
   

        
}
