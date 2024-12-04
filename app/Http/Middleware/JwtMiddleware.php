<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Kiểm tra token hợp lệ và xác thực người dùng
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            // Nếu token không hợp lệ hoặc hết hạn
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Đặt người dùng vào Auth để có thể sử dụng trong controller
        auth()->login($user);
    
        // Tiếp tục với yêu cầu
        return $next($request);
    }
    
}
