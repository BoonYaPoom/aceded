<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XFrameOptionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // เพิ่มหัว X-Frame-Options: DENY เพื่อป้องกันการฝังแอปของคุณในกรอบที่อาจเป็นอันตราย
        $response->headers->set('X-Frame-Options', 'DENY');

        return $response;
    }
}
