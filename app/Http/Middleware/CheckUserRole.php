<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\Users;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('loginId')) {
            $loginId = Session::get('loginId');
            $user = Users::where('user_id', $loginId)->first();

            if ($user && in_array($user->user_role, [1])) {
                return $next($request);
            }
        }

        return redirect('/'); // หรือส่งผู้ใช้ไปยังหน้าอื่นที่คุณต้องการ
    }
}
