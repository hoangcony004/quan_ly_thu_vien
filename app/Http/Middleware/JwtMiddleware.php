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
            // Kiểm tra nếu token hợp lệ
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            // Nếu token không hợp lệ hoặc hết hạn, trả về lỗi
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Tiếp tục xử lý nếu token hợp lệ
        return $next($request);
    }
}
