<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\PersonType;
use App\Models\Users;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function personTypes(){
            $userper = Users::all();
            $pertype = PersonType::all();
     return view('page.UserAdmin.group.umsgroup.index' ,compact('pertype','userper'));
    }
    public function create(){
 
     return view('page.UserAdmin.group.umsgroup.create' );
    }


    public function editname($person_type){
        $pertype = PersonType::findOrFail($person_type);
        return view('page.UserAdmin.group.umsgroup.editnameper',['pertype' => $pertype]);

    }

    public function store(Request $request){
        $pertype = new PersonType;
        $pertype->person = $request->person;

        $pertype->save();
        return redirect()->route('personTypes')->with('message','personTypes บันทึกข้อมูลสำเร็จ');
    }

    public function update(Request $request,$person_type){
        $pertype = PersonType::findOrFail($person_type);
        $pertype->person = $request->person;

        $pertype->save();
        return redirect()->route('personTypes')->with('message','personTypes บันทึกข้อมูลสำเร็จ');
    }

    public function pageperson($person_type){
        $pertype = PersonType::findOrFail($person_type);
        $users = Users::where('user_type', $pertype->person_type)->paginate(10);
        $usersnulls = Users::whereNull('user_type')->get();
        return view('page.UserAdmin.group.umsgroup.groupuser.create', compact('users', 'pertype','usersnulls'));
    }
    
    public function updateusertype(Request $request,$person_type){
        $pertype = PersonType::findOrFail($person_type);
        $usersnulls = Users::whereIn('uid', $request->input('user_data'))->get();
    
    foreach ($usersnulls as $user) {
        $user->user_type = $pertype->person_type;
        $user->save();
    }
    
    return redirect()->back()->with('message', 'personTypes บันทึกข้อมูลสำเร็จ');
}
public function search(Request $request)
{
    $searchTerm = $request->input('search');

    // Perform the search logic based on your requirements
    $results = Users::where('firstname', 'like', '%' . $searchTerm . '%')
                        ->orWhere('uid', 'like', '%' . $searchTerm . '%')
                        ->get();

    return view('page.UserAdmin.group.umsgroup.groupuser.create', ['results' => $results]);
}

    public function personDelete($person_type){
        $pertype = PersonType::findOrFail($person_type);
        $pertype->delete();

    Users::where('user_type', $pertype->person_type)->update(['user_type' => null]);

    return redirect()->back()->with('message', 'PersonType ลบข้อมูลสำเร็จ');

    }
   
}
