<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryTopic;
use App\Models\CourseSubject;
use App\Models\Department;
use Illuminate\Http\Request;

class CategoryTopicController extends Controller
{
    public function topicpage($category_id)
    {
        $Category  = Category::findOrFail($category_id);
        $topic = $Category->topics()->where('category_id', $category_id)->get();
        $subject_id =  $Category->subject_id;
        $subs  = CourseSubject::findOrFail($subject_id);
        $catac = $subs->Catt()->where('subject_id', $subject_id)->get();
        $department_id =   $subs->department_id;
        $depart = Department::findOrFail($department_id);
        return view('page.manage.sub.activitys.activcontent.catego.view', compact('Category', 'topic', 'subs','depart'));
    }
    public function destroy($topic_id)
    {
        $topic  = CategoryTopic::findOrFail($topic_id);

        $topic->delete();

        return redirect()->back()->with('message', 'topic ลบสำเร็จ');
    }

    public function changeStatuCategoryTopic(Request $request)
    {
        $topic = CategoryTopic::find($request->topic_id);

        if ($topic) {
            $topic->topic_status = $request->topic_status;
            $topic->save();

            return response()->json(['message' => 'สถานะถูกเปลี่ยนแปลงเรียบร้อยแล้ว']);
        } else {
            return response()->json(['message' => 'ไม่พบข้อมูล Topic']);
        }
    }
}
