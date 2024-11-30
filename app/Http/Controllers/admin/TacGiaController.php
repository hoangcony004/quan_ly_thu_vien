<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Models\admin\TacGia;

class TacGiaController extends Controller
{
    protected $title;

    public function index(Request $request) {}

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getTacGia()
    {
        $this->title = 'Admin - Tác Giả';
        $tacgiaList = TacGia::paginate(5);
        $query = null;
        return view('admin.pages.tac-gia')
            ->with('title', $this->title)
            ->with('tacgiaList', $tacgiaList)
            ->with('query', $query);
    }

    public function postAddTacGia(Request $request)
    {
        $request->validate([
            'tenTacGia' => 'required|string|max:255',
            'ngaySinh' => 'required|date',
            // 'trangThai' => 'nullable|boolean',
            'ngayMat' => 'nullable|date',
            'moTa' => 'nullable|string',
        ]);

        $data = $request->all();

        // Đặt trạng thái mặc định nếu không được gửi lên
        $data['trangThai'] = $request->has('trangThai');

        $ngaySinh = $request->ngaySinh;
        $ngayMat = $request->ngayMat;

        if (strtotime($ngaySinh) > time()) {
            // Nếu ngày sinh lớn hơn ngày hiện tại, trả về thông báo lỗi
            $this->notificationService->addNotification('Ngày sinh không thể lớn hơn ngày hiện tại!', 'error');
            return redirect()->back()->withInput();
        }

        // Kiểm tra nếu ngày mất trước ngày sinh
        if ($ngayMat) {
            // Kiểm tra nếu ngày mất trước ngày sinh
            if (strtotime($ngayMat) < strtotime($ngaySinh)) {
                $this->notificationService->addNotification('Ngày mất không thể trước ngày sinh!', 'error');
                return redirect()->back()->withInput();
            }

            // Kiểm tra nếu ngày mất lớn hơn ngày hiện tại
            if (strtotime($ngayMat) > time()) {
                $this->notificationService->addNotification('Ngày mất không thể lớn hơn ngày hiện tại!', 'error');
                return redirect()->back()->withInput();
            }
        }

        // Lưu dữ liệu vào cơ sở dữ liệu
        TacGia::create([
            'tenTacGia' => $request->tenTacGia,
            'ngaySinh' => $ngaySinh,
            'ngayMat' => $request->ngayMat ? $request->ngayMat : null,
            'trangThai' => $data['trangThai'],
            'moTa' => $request->moTa,
            'updated_at' => null,
            'created_at' => now(),
        ]);

        // Sử dụng NotificationService để gửi thông báo
        $this->notificationService->addNotification('Tác giả đã được thêm thành công!', 'success');

        return redirect()->route('tacgia.getTacGia');
    }

    public function getEditTacGia($id)
    {
        // Khai báo title
        $this->title = 'Admin - Sửa Tác Giả';

        // Tìm tác giả theo ID
        $tacgia = TacGia::find($id);

        // Nếu tác giả không tồn tại, trả về lỗi và thông báo
        if (!$tacgia) {
            // Gọi hàm addNotification tự trình này này vào service để gửi thông báo
            $this->notificationService->addNotification('Không tìm thấy tác giả cần sửa!', 'error');
            return redirect()->route('tacgia.getTacGia');
        }

        // Trả về view với dữ liệu 'tacgia' với title
        return view('admin.partials.tacgia.form-edit-tac-gia')
            ->with('title', $this->title)
            ->with('tacgia', $tacgia);
    }

    public function postEditTacGia($id, Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'tenTacGia' => 'required|string|max:255',
            'ngaySinh' => 'required|date',
            'ngayMat' => 'nullable|date',
            'moTa' => 'nullable|string',
        ]);

        // Tìm tác giả theo ID
        $tacgia = TacGia::find($id);

        // Nếu tác giả không tồn tại, trả về lỗi và thông báo
        if (!$tacgia) {
            // Gọi hàm addNotification từ service để gửi thông báo
            $this->notificationService->addNotification('Không tìm thấy tác giả cần sửa!', 'error');
            return redirect()->route('tacgia.getTacGia');
        }

        // Kiểm tra nếu ngày sinh lớn hơn ngày hiện tại
        $ngaySinh = $request->ngaySinh;
        $ngayMat = $request->ngayMat;

        // Kiểm tra nếu ngày sinh lớn hơn ngày hiện tại
        if (strtotime($ngaySinh) > time()) {
            $this->notificationService->addNotification('Ngày sinh không thể lớn hơn ngày hiện tại!', 'error');
            return redirect()->back()->withInput();
        }

        // Kiểm tra nếu ngày mất trước ngày sinh
        if ($ngayMat) {
            // Kiểm tra nếu ngày mất trước ngày sinh
            if (strtotime($ngayMat) < strtotime($ngaySinh)) {
                $this->notificationService->addNotification('Ngày mất không thể trước ngày sinh!', 'error');
                return redirect()->back()->withInput();
            }

            // Kiểm tra nếu ngày mất lớn hơn ngày hiện tại
            if (strtotime($ngayMat) > time()) {
                $this->notificationService->addNotification('Ngày mất không thể lớn hơn ngày hiện tại!', 'error');
                return redirect()->back()->withInput();
            }
        }


        $data = $request->all();

        // Đặt trạng thái mặc định nếu không được gửi lên
        $data['trangThai'] = $request->has('trangThai');

        // Cập nhật thông tin tác giả
        $tacgia->update([
            'tenTacGia' => $request->tenTacGia,
            'ngaySinh' => $ngaySinh,
            'ngayMat' => $request->ngayMat ? $request->ngayMat : null,
            'trangThai' => $data['trangThai'],
            'moTa' => $request->moTa,
            'updated_at' => now(),
        ]);

        // Thêm thông báo thành công
        $this->notificationService->addNotification('Đã sửa tác giả thành công.', 'success');

        return redirect()->route('tacgia.getTacGia');
    }

    public function postDeleteTacGia($id)
    {
        // Tìm tác giả theo ID
        $tacgia = TacGia::find($id);

        // Nếu tác giả không tồn tại, trả về lỗi và thông báo
        if (!$tacgia) {
            // Gọi hàm addNotification từ service để gửi thông báo
            $this->notificationService->addNotification('Không tìm thấy tác giả cần xóa!', 'error');
            return redirect()->route('tacgia');
        }

        // Xóa tác giả
        $tacgia->delete();

        // Sử dụng NotificationService để gửi thông báo
        $this->notificationService->addNotification('Tác giả đã được xóa thành công!', 'success');

        return redirect()->route('tacgia.getTacGia');
    }

    public function getTimKiemTacGia(Request $request)
    {
        // Khai báo title
        $this->title = 'Admin - Tìm Kiếm Tác Giả';

        // Lấy giá trị tìm kiếm từ request
        $query = $request->input('query');

        $tacgiaList = TacGia::where('tenTacGia', 'like', '%' . $query . '%')->paginate(5);

        // Sử dụng NotificationService để gửi thông báo
        $this->notificationService->addNotification('Tìm kiếm tác giả thành công!', 'success');

        return view('admin.pages.tac-gia')
            ->with('title', $this->title)
            ->with('tacgiaList', $tacgiaList)
            ->with('query', $query);
    }

    public function getAPITacGia(Request $request)
    {
        $search = $request->input('search'); // Lấy từ khóa tìm kiếm
        $tacGias = TacGia::where('trangThai', true)
            ->where('tenTacGia', 'LIKE', "%$search%")
            ->take(10) // Giới hạn số lượng kết quả trả về
            ->get(['id', 'tenTacGia']); // Chỉ lấy cột cần thiết

        return response()->json($tacGias);
    }
}
