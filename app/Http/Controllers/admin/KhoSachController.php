<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\KhoSach;
use App\Services\NotificationService;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class KhoSachController extends Controller
{
    protected $title;

    protected $notificationService; // Khai báo service thông báo

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService; // Khởi tạo service thông báo
    }

    public function index(Request $request) {}

    public function getKhoSach()
    {
        // Khai báo title
        $this->title = 'Admin - Kho Sách';

        $query = null;
        $khoSachList = KhoSach::paginate(5);

        return view('admin.pages.kho-sach')
            ->with('title', $this->title)
            ->with('khoSachList', $khoSachList)
            ->with('query', $query);
    }

    public function postAddSach(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'tenSach' => 'required|string|max:255',
            'maTacGia' => 'required|integer',
            'maTheLoai' => 'required|integer',
            'maNhaXuatBan' => 'required|integer',
            'ngayXuatBan' => 'required|date',
            'soLuong' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'moTa' => 'required|string|max:500',
        ]);

        $ngayXuatBan = $request->ngayXuatBan;
        if (strtotime($ngayXuatBan) > time()) {
            // Nếu ngày sinh lớn hơn ngày hiện tại, trả về thông báo lỗi
            $this->notificationService->addNotification('Ngày xuất bản không thể lớn hơn ngày hiện tại!', 'error');
            return redirect()->back()->withInput();
        }

        // Cấu hình Cloudinary
        Configuration::instance([
            'cloud' => [
                'cloud_name' => 'duwg8ygye',
                'api_key' => '437687328334798',
                'api_secret' => 'UVvthgt95W8FVlJmBZvMtZwIHRs',
            ]
        ]);

        // Kiểm tra xem người dùng có tải ảnh lên hay không
        $imageUrl = null; // Mặc định là null
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // Lấy file từ request
            try {
                // Tải ảnh lên Cloudinary
                $upload = (new UploadApi())->upload($file->getPathname());
                $imageUrl = $upload['secure_url']; // Lấy URL ảnh từ Cloudinary
            } catch (\Exception $e) {
                $this->notificationService->addNotification('Lỗi khi tải ảnh lên. Vui lòng thử lại!', 'error');
                return back()->withInput();
            }
        }

        // Tạo mã sách ngẫu nhiên
        $maSach = $this->generateMaSach();

        // Lưu thông tin sách vào database
        KhoSach::create([
            'tenSach' => $request->tenSach,
            'maSach' => $maSach,
            'maTacGia' => $request->maTacGia,
            'maTheLoai' => $request->maTheLoai,
            'maNhaXuatBan' => $request->maNhaXuatBan,
            'ngayXuatBan' => $request->ngayXuatBan,
            'soLuong' => $request->soLuong,
            'moTa' => $request->moTa,
            'image' => $imageUrl, // Đường dẫn ảnh Imgur
            'created_at' => now(),
        ]);

        // Thông báo thành công
        $this->notificationService->addNotification('Sách đã được thêm thành công!', 'success');

        return redirect()->route('khosach.getKhoSach');
    }

    public function getEditSach($id)
    {
        // Khai báo title
        $this->title = 'Admin - Sửa Sách';

        // Tìm nhà xuất bản theo ID
        $khosach = KhoSach::find($id);

        // Chuyển hướng
        return view('admin.partials.khosach.form-edit-sach', compact('khosach'))
            ->with('title', $this->title);
    }

    public function postEditSach(Request $request, $id)
    {
        // Xác thức dữ liệu
        $request->validate([
            'tenSach' => 'required|string|max:255',
            'maTacGia' => 'required|integer',
            'maTheLoai' => 'required|integer',
            'maNhaXuatBan' => 'required|integer',
            'ngayXuatBan' => 'required|date',
            'soLuong' => 'required|integer|min:1',
            'moTa' => 'required|string|max:500',
        ]);

        // Tìm nhà xuất bản theo ID
        $khosach = KhoSach::find($id);

        // Cấu hình Cloudinary
        Configuration::instance([
            'cloud' => [
                'cloud_name' => 'duwg8ygye',
                'api_key' => '437687328334798',
                'api_secret' => 'UVvthgt95W8FVlJmBZvMtZwIHRs',
            ]
        ]);

        // Kiểm tra xem người dùng có tải ảnh lên hay không
        $imageUrl = $khosach->image; // Mặc định giữ URL ảnh cũ

        if ($request->hasFile('image')) {
            $file = $request->file('image'); // Lấy file từ request
            try {
                // Tải ảnh lên Cloudinary
                $upload = (new UploadApi())->upload($file->getPathname());
                $imageUrl = $upload['secure_url']; // Lấy URL ảnh từ Cloudinary
            } catch (\Exception $e) {
                $this->notificationService->addNotification('Lỗi khi tải ảnh lên. Vui lòng thử lại!', 'error');
                return back()->withInput();
            }
        }

        // Cập nhật thống tin sách
        $khosach->update([
            'tenSach' => $request->tenSach,
            'maTacGia' => $request->maTacGia,
            'maTheLoai' => $request->maTheLoai,
            'maNhaXuatBan' => $request->maNhaXuatBan,
            'ngayXuatBan' => $request->ngayXuatBan,
            'soLuong' => $request->soLuong,
            'moTa' => $request->moTa,
            'image' => $imageUrl, // Đường dẫn ảnh Imgur
        ]);

        // Thêm thông báo thành công vào session
        $this->notificationService->addNotification('Sách được cập nhật thống công!', 'success');

        return redirect()->route('khosach.getKhoSach');
    }

    public function postDeleteSach($id)
    {
        // Tìm nhà xuất bản theo ID
        $khosach = KhoSach::find($id);

        // Kiểm tra nếu tồn tại thể loại
        if ($khosach) {
            // Xóa thể loại
            $khosach->delete();

            // Thêm thông báo thành công vào session
            $this->notificationService->addNotification('Sách đã được xóa thành công!', 'success');
        } else {
            // Thêm thông báo lỗi nếu không tìm thấy thể loại
            $this->notificationService->addNotification('Không tìm thấy sach!', 'error');
        }

        return redirect()->route('khosach.getKhoSach');
    }

    public function getSearchSach(Request $request)
    {
        // Khai báo title
        $this->title = 'Admin - Tìm Kiếm Nhà Xuất Bản';

        $query = $request->input('query');

        $khoSachList = KhoSach::where('maSach', 'LIKE', "%$query%")->paginate(5);

        $this->notificationService->addNotification('Tìm kiếm sách thành công!', 'success');

        return view('admin.pages.kho-sach')
            ->with('title', $this->title)
            ->with('khoSachList', $khoSachList)
            ->with('query', $query);
    }


    private function generateMaSach()
    {
        do {
            // Tạo mã sách ngẫu nhiên 8 số
            $maSach = 'MS' . random_int(10000000, 99999999); // Ví dụ: MS12345678
        } while (KhoSach::where('maSach', $maSach)->exists()); // Kiểm tra xem mã sách đã tồn tại chưa

        return $maSach; // Trả về mã sách duy nhất
    }
}
