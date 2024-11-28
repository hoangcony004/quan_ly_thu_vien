<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

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

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            session(['name' => $user->name]);
            session(['role' => $user->role]);
            session(['image' => $user->image]);

            // Giả sử đăng nhập thành công
            // session()->flash('success', 'Đăng nhập thành công.');
            $this->notificationService->addNotification('Đăng nhập thành công!', 'success');
            // dd(session('notifications')); // In dữ liệu session ra để kiểm tra


            // Lấy URL đã lưu trước khi đăng nhập hoặc chuyển hướng đến dashboard nếu không có
            return redirect()->intended(route('dashboard'));
        } else {
            // Thông báo lỗi giữ nguyên cách cũ
            session()->flash('error', 'Sai tên đăng nhập hoặc mật khẩu!');
            return redirect()->back()->withInput();
        }

        // Nếu đăng nhập không thành công
        session()->flash('error', 'Thông tin đăng nhập không đúng.'); // Thông báo lỗi
        return redirect()->back()->withInput(); // Giữ lại các giá trị đã nhập
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
}
