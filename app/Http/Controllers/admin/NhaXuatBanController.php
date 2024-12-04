<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\NhaXuatBan;
use App\Services\NotificationService;

class NhaXuatBanController extends Controller
{
    protected $title;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request) {}

    public function getNhaXuatBan()
    {

        // Khai báo title
        $this->title = 'Admin - Nhà Xuất Bản';
        $query = null;
        // Truy vấn lấy dữ liệu từ bảng với phân trang 5 phần tử 1 trang
        $nhaxuatbanList = NhaXuatBan::paginate(5);

        // Trả về view với dữ liệu 'tacgiaList'
        return view('admin.pages.nha-xuat-ban')
            ->with('title', $this->title)
            ->with('nhaxuatbanList', $nhaxuatbanList)
            ->with('query', $query);
    }

    public function postAddNhaXuatBan(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'tenNhaXuatBan' => 'required|string|max:255',
            'soDienThoai' => 'required|digits_between:1,12',
            'email' => 'nullable|email|max:255',
            'diaChi' => 'required|string',
        ]);        

        $data = $request->all();

        // Đặt trạng thái mặc định nếu không được gửi lên
        $data['trangThai'] = $request->has('trangThai');

        // Lưu dữ liệu vào model NhaXuatBan
        NhaXuatBan::create([
            'tenNhaXuatBan' => $request->tenNhaXuatBan,
            'soDienThoai' => $request->soDienThoai,
            'email' => $request->email,
            'trangThai' => $data['trangThai'],
            'diaChi' => $request->diaChi,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        $this->notificationService->addNotification('Nhà xuất bản đã được thêm thành công!', 'success');

        // Chuyển hướng hoặc thông báo thành công
        return redirect()->route('nhaxuatban.getNhaXuatBan');
    }

    public function getEditNhaXuatBan($id)
    {
        // Khai báo title
        $this->title = 'Admin - Sửa Nhà Xuất Bản';

        // Tìm nhà xuất bản theo ID
        $nhaxuatban = NhaXuatBan::find($id);

        // Chuyển hướng
        return view('admin.partials.nhaxuatban.form-edit-nha-xuat-ban', compact('nhaxuatban'))
            ->with('title', $this->title);
    }

    public function postEditNhaXuatBan(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'tenNhaXuatBan' => 'required|string|max:255',
            'soDienThoai' => 'required|digits_between:1,12',
            'email' => 'nullable|email|max:255',
            'diaChi' => 'required|string',
        ]);        

        // Tìm nhà xuất bản theo ID
        $nhaxuatban = NhaXuatBan::find($id);
        if (!$nhaxuatban) {
            // Nếu không tìm thấy nhà xuất bản, trả về thông báo lỗi
            $this->notificationService->addNotification('Nhà xuất bản không tồn tại!', 'error');
            return redirect()->route('nhaxuatban.getNhaXuatBan');
        }

        $data = $request->all();

        // Đặt trạng thái mặc định nếu không được gửi lên
        $data['trangThai'] = $request->has('trangThai');

        // Cập nhật dữ liệu vào cơ sở dữ liệu
        $nhaxuatban->update([
            'tenNhaXuatBan' => $request->tenNhaXuatBan,
            'soDienThoai' => $request->soDienThoai,
            'email' => $request->email,
            'trangThai' => $data['trangThai'],
            'diaChi' => $request->diaChi,
            'updated_at' => now(),
        ]);

        // Thêm thông báo thành công
        $this->notificationService->addNotification('Nhà xuất bản được cập nhật!', 'success');

        // Chuyển hướng về trang danh sách nhà xuất bản
        return redirect()->route('nhaxuatban.getNhaXuatBan');
    }

    public function postDeleteNhaXuatBan($id)
    {
        // Tìm nhà xuất bản theo ID
        $nhaxuatban = NhaXuatBan::find($id);

        // Kiểm tra nếu tồn tại thể loại
        if ($nhaxuatban) {
            // Xóa thể loại
            $nhaxuatban->delete();

            // Thêm thông báo thành công vào session
            $this->notificationService->addNotification('Nhà xuất bản đã được xóa thành công!', 'success');
        } else {
            // Thêm thông báo lỗi nếu không tìm thấy thể loại
            $this->notificationService->addNotification('Không tìm thấy nhà xuất bản!', 'error');
        }

        return redirect()->route('nhaxuatban.getNhaXuatBan');
    }

    public function getSearchNhaXuatBan(Request $request)
    {
        // Khai báo title
        $this->title = 'Admin - Tìm Kiếm Nhà Xuất Bản';

        // Lấy giá trị tìm kiếm từ request
        $query = $request->input('query');

        $nhaxuatbanList = NhaXuatBan::where('tenNhaXuatban', 'like', '%' . $query . '%')->paginate(5);

        // Sử dụng NotificationService để gửi thông báo
        $this->notificationService->addNotification('Tìm kiếm thể loại thành công!', 'success');

        return view('admin.pages.nha-xuat-ban')
            ->with('title', $this->title)
            ->with('nhaxuatbanList', $nhaxuatbanList)
            ->with('query', $query);
    }

    public function getAPINhaXuatBan(Request $request)
    {
        $search = $request->input('search'); // Lấy từ khóa tìm kiếm
        $nhaXuatBans = NhaXuatBan::where('trangThai', true) // Chỉ lấy bản ghi có trạng thái là true
            ->where('tenNhaXuatBan', 'LIKE', "%$search%") // Lọc theo từ khóa tìm kiếm
            ->take(10) // Giới hạn số lượng kết quả trả về
            ->get(['id', 'tenNhaXuatBan']); // Chỉ lấy cột cần thiết
    
        return response()->json($nhaXuatBans);
    }
    
}
