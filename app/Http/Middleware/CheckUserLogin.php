<?php

namespace App\Http\Middleware;

use App\Models\Department;
use App\Models\General;
use App\Models\Log;
use App\Models\Users;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View as FacadesView;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (Session::has('loginId')) {
                $loginId = Session::get('loginId');
                $data = Users::where('user_id', '=', $loginId)->first();
                $logo = General::where('id', 1)->first();
                FacadesView::share('logo', $logo);
                FacadesView::share('data', $data);
                $ip = $request->ip();
                $loginTime = now()->format('Y-m-d H:i:s');
            
                $userAgent = $request->header('User-Agent');
            
                $os = $this->getOperatingSystemFromUserAgent($userAgent);
            
                $browser = $this->getBrowserFromUserAgent($userAgent);
            
                $this->saveLoginLog($loginId, $ip, $loginTime, $os, $browser);

            }
        } catch (\Exception $e) {
            return response()->view('error.error-500', [], 500);
        }
            
        return $next($request);
    }
    
    private function getBrowserFromUserAgent($userAgent)
    {
        $browser = 'Unknown';

        if (preg_match('/(Chrome|Firefox|Safari|Opera|Edge|IE)[\/\s](\d+\.\d+)/i', $userAgent, $matches)) {
            $browser = $matches[1];
        }

        return $browser;
    }
    private function getOperatingSystemFromUserAgent($userAgent)
    {
        // สร้างรายการเงื่อนไขสำหรับการตรวจสอบระบบปฏิบัติการ
        $conditions = [
            'Windows' => 'Windows',
            'Windows 10' => 'Windows 10',
            'Windows 11' => 'Windows 11',
            'Mac' => 'Macintosh|Mac OS',
            'Linux' => 'Linux',
            'Android' => 'Android',
            'iOS' => 'iPhone|iPad|iPod',
        ];

        // วนลูปเงื่อนไขและตรวจสอบระบบปฏิบัติการ
        foreach ($conditions as $os => $pattern) {
            if (preg_match("/$pattern/i", $userAgent)) {
                return $os;
            }
        }

        return 'Unknown';
    }
    private function saveLoginLog($loginId, $ip, $loginTime, $os, $browser)
    {
        if ($loginId) {
            $loginLog = Log::where('user_id', $loginId)->where('logid', 1)->first();

            if (!$loginLog) {
                $loginLog = new Log();
                $loginLog->logid = 1;
                $loginLog->logaction = 1;
                $loginLog->logdetail = '';
                $loginLog->idref  = 1;
                $loginLog->subject_id  = 1;
                $loginLog->duration = 1;
                $loginLog->status  = 0;
                $loginLog->user_id = $loginId;
                $loginLog->logagents = $browser;
                $loginLog->logip = $ip;
                $loginLog->logdate = $loginTime;
                $loginLog->logplatform = $os;

                $loginLog->save();
            }
        }
    }
}
