<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $title;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request) {}

    public function getLogin()
    {
        // Nếu người dùng đã đăng nhập, chuyển hướng đến Dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Thay 'admin.dashboard' bằng route dashboard của bạn
        }

        // Khai báo title
        $this->title = 'Admin - Login';

        // Chuyển hướng và truyền thông báo xuống
        return view('admin.auth.login-admin')->with('title', $this->title);
    }

    public function postLogin(Request $request)
    {
        // Kiểm duyệt dữ liệu với thông báo lỗi tùy chỉnh
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'g-recaptcha-response.required' => 'Vui lòng xác nhận rằng bạn không phải là robot.',
            'g-recaptcha-response.captcha' => 'Xác minh reCAPTCHA không thành công, vui lòng thử lại.',
        ]);
    
        // Xử lý đăng nhập sau khi kiểm tra reCAPTCHA
        $credentials = $request->only('username', 'password');
    
        // Kiểm tra nếu thông tin đăng nhập chính xác
        if (Auth::attempt($credentials)) {
            // Lấy thông tin người dùng sau khi đăng nhập thành công
            $user = Auth::user();
    
            // Tạo JWT Token
            $token = JWTAuth::fromUser($user);

            // dd($token);die;
    
            // Lưu token vào session hoặc cookie nếu cần thiết
            session(['name' => $user->name]);
            session(['role' => $user->role]);
            session(['image' => $user->image]);
            session(['token' => $token]); // Lưu token vào session
    
            // Sử dụng NotificationService để gửi thông báo cho đăng nhập thành công
            $this->notificationService->addNotification('Đăng nhập thành công!', 'success');
    
            // Chuyển hướng đến dashboard hoặc trang tiếp theo
            return redirect()->intended(route('dashboard'));
        } else {
            // Thông báo lỗi nếu thông tin đăng nhập không chính xác
            session()->flash('error', 'Sai tên đăng nhập hoặc mật khẩu!');
            return redirect()->back()->withInput();
        }
    }    

    public function getLogout()
    {
        Auth::logout(); // Đăng xuất người dùng

        // Xóa toàn bộ session
        session()->invalidate();
        session()->regenerateToken(); // Tạo lại CSRF token để bảo mật

        // Gửi thông báo đăng xuất thành công
        session()->flash('success', 'Đăng xuất thành công.');

        return redirect()->route('auth.getLogin'); // Chuyển hướng đến trang đăng nhập
    }

    public function getToken(Request $request)
    {
        // Kiểm tra nếu người dùng đã đăng nhập bằng session
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Tạo token JWT cho người dùng
        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token]);
    }
}
