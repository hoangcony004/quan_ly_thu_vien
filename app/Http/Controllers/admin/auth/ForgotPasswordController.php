<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    protected $title;

    public function showLinkRequestForm()
    {
        // Khai báo title
        $this->title = 'Admin - Reset Password';

        return view('admin.auth.form-reset-password')
            ->with('title', $this->title);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Kiểm tra nếu đã có yêu cầu đặt lại mật khẩu trước đó
        $existingReset = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if ($existingReset) {
            $createdAt = Carbon::parse($existingReset->created_at);

            // Nếu yêu cầu trước đó được gửi trong vòng 15 phút, ngăn không cho gửi lại
            if ($createdAt->diffInMinutes(Carbon::now()) < 15) {
                return back()->withErrors(['email' => 'Bạn đã yêu cầu đặt lại mật khẩu gần đây. Vui lòng chờ 15 phút trước khi thử lại.']);
            }
        }

        // Tạo token mới và lưu vào bảng password_reset_tokens
        $token = Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        // Gửi email
        $link = url('/reset-password/'.$token.'?email='.urlencode($request->email));
        Mail::send('admin.auth.password-reset', [
            'link' => $link
        ], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Reset Password');
        });

        return back()->with('success', 'Đã gửi email xác minh thành công!');
    }


    public function showResetForm($token)
    {
        // Khai báo title
        $this->title = 'Admin - Reset Password';

        $email = request()->query('email'); 

        // Kiểm tra xem token có tồn tại trong database không
        $emailRecord = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$emailRecord) {
            // Nếu token không tồn tại, trả về view lỗi
            return view('admin.auth.error-reset-password')
                ->with('message', 'Token không hợp lệ hoặc đã hết hạn. Vui Lòng Thử Lại Sau.')
                ->with('title', $this->title);
        }

        return view('admin.auth.reset-password', ['token' => $token])
            ->with('title', $this->title);
    }

    public function reset(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ], [
            'password_confirmation.same' => 'Mật khẩu xác nhận không khớp với mật khẩu mới.',
        ]);

        // Kiểm tra token reset password
        $reset = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['email' => 'Liên kết đặt lại mật khẩu không hợp lệ!']);
        }

        // Đổi mật khẩu cho người dùng
        $user = \App\Models\User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->r_password = $request->password;
        $user->save();

        // Xóa token reset password sau khi hoàn thành
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('auth.getLogin')->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }
}
