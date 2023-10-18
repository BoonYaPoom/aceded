<?php

namespace App\Http\Middleware;

use App\Models\Department;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View as FacadesView;
class CheckDepartmentLogo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $department_id = $request->route('department_id');
        $department = Department::findOrFail($department_id);
        $logoDep = $department->GenDe()->first();

        if ($logoDep) {
            // ถ้ามี logo ให้เก็บไฟล์ logo ในตัวแปร $logo และแชร์ไปยัง View
            FacadesView::share('logoDep', $logoDep);

            return $next($request);
        }
        // ถ้าไม่มี logo สามารถแสดงข้อความผิดพลาดหรือส่งผู้ใช้ไปที่หน้าอื่น ๆ
        return redirect()->route('errorPage'); 

    }
}
