<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Kiểm tra xem yêu cầu có mong đợi trả về JSON không
        if (!$request->expectsJson()) {
            return route('auth.getLogin'); // Trả về route login nếu không phải JSON request
        }

        // Nếu yêu cầu là JSON và không xác thực, trả về lỗi 401
        return response()->json(['error' => 'Unauthorized'], 401);
    }

}

