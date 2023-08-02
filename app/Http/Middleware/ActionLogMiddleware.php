<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Logaction; // Import model LogAction
use App\Models\Log; // Import model Log

class ActionLogMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // ตรวจสอบว่าเป็นเมธอด POST หรือ PUT (การสร้างหรือแก้ไขข้อมูล)
        if ($request->isMethod('post', 'put')) {
            $route = $request->route();
            $action = $route ? $route->getAction() : [];

            // ตรวจสอบว่าเป็นการสร้างหรือแก้ไข
            $actionType = $request->isMethod('post') ? 'add' : 'update';

            // ดึงข้อมูลจากตาราง moc_logaction
            $logAction = Logaction::where('actionid', '=', $actionType)->first();

            // บันทึกข้อมูลการกระทำและรายละเอียดคำขอ
            $logId = $logAction->actionid ?? null;
            if ($logId) {
                $log = new Log();
                $log->description = $request->all();
                $log->logaction =  $logId;

                $log->save();
            }
        }

        return $response;
    }
}
