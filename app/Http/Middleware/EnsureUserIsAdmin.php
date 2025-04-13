<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra đã đăng nhập VÀ có phải admin không
        if (!Auth::check() || !$request->user()->isAdmin()) {
            return redirect('/login')->with('error', 'Bạn không có quyền truy cập khu vực này.');
        }
        return $next($request);
    }
}
