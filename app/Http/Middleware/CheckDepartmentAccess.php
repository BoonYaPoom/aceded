<?php

namespace App\Http\Middleware;

use App\Models\Department;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDepartmentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
           // ดึงค่า department_id จากคำขอ
           $departmentId = $request->route('department_id'); // ต้องมี parameter ชื่อ 'department_id' ใน Route

           // ตรวจสอบว่า department_id มีอยู่ในฐานข้อมูลหรือไม่
           $depart = Department::find($departmentId);
   
           if (!$depart) {
               // ถ้าไม่พบ department_id ในฐานข้อมูล สามารถทำการ redirect หรือส่ง response ตามต้องการได้
               return redirect()->route('not-found-route'); // เช่น ส่งไปยังหน้า 404
           }
   
           // หากต้องการให้ส่งผ่าน department ไปยัง controller ต่อไป
           // สามารถเพิ่ม department เข้าไปในคำขอก่อนส่งต่อได้
           $request->attributes->add(['depart' => $depart]);
   
           return $next($request);
    
    }
}
