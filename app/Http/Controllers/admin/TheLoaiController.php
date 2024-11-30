<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\TheLoai;
use App\Services\NotificationService;

class TheLoaiController extends Controller
{
    protected $title;

    public function index(Request $request) {}

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getTheLoai()
    {
        // Khai báo title
        $this->title = 'Admin - Thể Loại';

        // Truy vấn lưu dữ liệu từ bảng 'the_loai' với phân trang 5 phần tử 1 trang
        $theloaiList = TheLoai::paginate(5);
        $query = null;
        // Chuyển hướng và truyền thông báo xuất
        return view('admin.pages.the-loai')
            ->with('title', $this->title)
            ->with('theloaiList', $theloaiList)
            ->with('query', $query);
    }

    public function postAddTheLoai(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $request->validate([
                'tenTheLoai' => 'required|string|max:255',
            ]);

            // Kiểm tra xem thể loại đã tồn tại chưa
            $existingTheLoai = TheLoai::where('tenTheLoai', $request->tenTheLoai)->first();
            if ($existingTheLoai) {
                // Nếu thể loại đã tồn tại, thông báo lỗi
                $this->notificationService->addNotification('Thể loại "' . $request->tenTheLoai . '" đã tồn tại!', 'error');
                return redirect()->route('theloai.getTheLoai');
            }

            $data = $request->all();

            // Đặt trạng thái mặc định nếu không được gửi lên
            $data['trangThai'] = $request->has('trangThai');

            // Lưu dữ liệu vào cơ sở dữ liệu
            TheLoai::create([
                'tenTheLoai' => $request->tenTheLoai,
                'trangThai'  => $data['trangThai'],
                'created_at' => now(), // Gán ngày tạo
                'updated_at' => null,   // Đặt giá trị null cho ngày sửa
            ]);

            // Gọi hàm addNotification từ service
            $this->notificationService->addNotification('Đã thêm thể loại thành công!', 'success');

            // Chuyển hướng khi thành công
            return redirect()->route('theloai.getTheLoai');
        } catch (\Exception $e) {
            // Xử lý khi có lỗi
            $this->notificationService->addNotification('Đã xảy ra lỗi. Mã lỗi: ' . $e->getMessage(), 'error');
            return redirect()->route('theloai.getTheLoai');
        }
    }

    public function getEditTheLoai($id)
    {
        // Khai báo title
        $this->title = 'Admin - Sửa Thể Loại';

        // Tìm thể loại theo ID
        $theloai = TheLoai::find($id);

        // Chuyển hướng
        return view('admin.partials.theloai.form-edit-the-loai', compact('theloai'))
            ->with('title', $this->title);
    }

    public function postEditTheLoai(Request $request, $id)
    {
        try {
            // Validate dữ liệu đầu vào
            $request->validate([
                'tenTheLoai' => 'required|string|max:255',
            ]);

            // Tìm thể loại theo ID
            $theloai = TheLoai::find($id);
            if (!$theloai) {
                // Nếu không tìm thấy thể loại, trả về thông báo lỗi
                $this->notificationService->addNotification('Thể loại không tồn tại!', 'error');
                return redirect()->route('theloai.getTheLoai');
            }

            // Kiểm tra xem tên thể loại mới đã tồn tại chưa (trừ thể loại hiện tại)
            $existingTheLoai = TheLoai::where('tenTheLoai', $request->tenTheLoai)->where('id', '!=', $id)->first();
            if ($existingTheLoai) {
                // Nếu thể loại đã tồn tại, thông báo lỗi
                $this->notificationService->addNotification('Thể loại "' . $request->tenTheLoai . '" đã tồn tại!', 'error');
                return redirect()->route('theloai.getTheLoai');
            }

            $data = $request->all();

            // Đặt trạng thái mặc định nếu không được gửi lên
            $data['trangThai'] = $request->has('trangThai');

            // Lưu dữ liệu vào cơ sở dữ liệu
            $theloai->update([
                'tenTheLoai' => $request->tenTheLoai,
                'trangThai'  => $data['trangThai'],
                'updated_at' => now(), // Gán ngày cập nhật
            ]);

            // Gọi hàm addNotification từ service
            $this->notificationService->addNotification('Đã sửa thể loại thành công!', 'success');

            // Chuyển hướng
            return redirect()->route('theloai.getTheLoai');
        } catch (\Exception $e) {
            // Xử lý khi có lỗi
            $this->notificationService->addNotification('Đã xảy ra lỗi. Mã Lỗi: ' . $e->getMessage(), 'error');
            return redirect()->route('theloai.getTheLoai');
        }
    }

    public function postDeleteTheLoai($id)
    {
        // Tìm thể loại theo ID
        $theloai = TheLoai::find($id);

        // Kiểm tra nếu tồn tại thể loại
        if ($theloai) {
            // Xóa thể loại
            $theloai->delete();

            // Thêm thông báo thành công vào session
            $this->notificationService->addNotification('Thể loại đã được xóa thành công!', 'success');
        } else {
            // Thêm thông báo lỗi nếu không tìm thấy thể loại
            $this->notificationService->addNotification('Không tìm thấy thể loại!', 'error');
        }

        // Chuyển hướng về trang thể loại
        return redirect()->route('theloai.getTheLoai');
    }

    public function getSearchTheLoai(Request $request)
    {
        // Khai báo title
        $this->title = 'Admin - Tìm Kiếm Thể Loại';

        // Lấy giá trị tìm kiếm từ request
        $query = $request->input('query');

        $theloaiList = TheLoai::where('tenTheLoai', 'like', '%' . $query . '%')->paginate(5);

        // Sử dụng NotificationService để gửi thông báo
        $this->notificationService->addNotification('Tìm kiếm thể loại thành công!', 'success');

        return view('admin.pages.the-loai')
            ->with('title', $this->title)
            ->with('theloaiList', $theloaiList)
            ->with('query', $query);
    }

    public function getAPITheLoai(Request $request)
    {
        $search = $request->input('search'); // Lấy từ khóa tìm kiếm
        $theLoais = TheLoai::where('trangThai', true)
            ->where('tenTheLoai', 'LIKE', "%$search%")
            ->take(10) // Giới hạn số lượng kết quả trả về
            ->get(['id', 'tenTheLoai']); // Chỉ lấy cột cần thiết

        return response()->json($theLoais);
    }
}
