<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Models\admin\KhoSach;
use App\Models\admin\MuonSach;
use App\Models\admin\ChiTietMuonSach;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuanLyMuonSachController extends Controller
{
    protected $title;

    public function index(Request $request) {}

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getQuanLyMuonSach()
    {
        $this->title = 'Admin - Quản Lý Mượn Sách';

        $muonSachList = MuonSach::paginate(5);

        $query = null;

        return view('admin.pages.quan-ly-muon-sach')
            ->with('title', $this->title)
            ->with('muonSachList', $muonSachList)
            ->with('query', $query);
    }

    public function postAddMuonSach(Request $request)
    {
        // Xác thực đầu vào
        $request->validate([
            'maMuon' => 'required|array|min:1|max:10',
            'maMuon.*' => 'required|exists:sach,id',
            'soLuongSach' => 'required|array|min:1|max:10',
            'soLuongSach.*' => 'required|integer|min:1|max:10',
            'tenNguoiMuon' => 'required|string|max:255',
            'soLuong' => 'required|integer|min:1',
            'email' => 'required|email',
            'soDienThoai' => 'required|digits_between:1,12',
            'ngayMuon' => 'required|date|before_or_equal:today',
            'ngayTra' => 'required|date|after_or_equal:ngayMuon',
        ]);

        // Chuẩn bị dữ liệu cần thiết
        $maMuonSach = $this->generateMaMuonSach();

        try {
            DB::beginTransaction(); // Bắt đầu transaction

            // Tạo bản ghi trong bảng MuonSach
            $muonSach = MuonSach::create([
                'maMuonSach' => $maMuonSach,
                'tenNguoiMuon' => $request->tenNguoiMuon,
                'soLuong' => $request->soLuong,
                'email' => $request->email,
                'soDienThoai' => $request->soDienThoai,
                'ngayMuon' => $request->ngayMuon,
                'ngayTra' => $request->ngayTra,
                'trangThai' => 1,
                'created_at' => now(),
            ]);

            $muonSachId = $muonSach->id;

            // Tạo bản ghi trong bảng ChiTietMuonSach
            $chiTietData = [];
            foreach ($request->maMuon as $index => $sachId) {
                $chiTietData[] = [
                    'maMuon' => $muonSachId,
                    'maSach' => $sachId,
                    'soLuong' => $request->soLuongSach[$index],
                    'created_at' => now(),
                ];
            }
            ChiTietMuonSach::insert($chiTietData); // Chèn nhiều bản ghi cùng lúc

            DB::commit(); // Xác nhận transaction
            $this->notificationService->addNotification('Thêm người mượn thành công!', 'success');

            return redirect()->route('quanlymuonsach.getQuanLyMuonSach');
        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác tất cả thay đổi khi lỗi xảy ra

            Log::error('Lỗi khi thêm thông tin mượn sách: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi thêm thông tin mượn sách. Vui lòng thử lại sau.']);
        }
    }


    public function postDeleteMuonSach($id)
    {
        // Tìm người mượn sách theo ID
        $muonsach = MuonSach::find($id);

        // Nếu không tìm thấy người mượn sách, trả về thông báo lỗi
        if (!$muonsach) {
            // Gọi hàm addNotification từ service để gửi thông báo
            $this->notificationService->addNotification('Không tìm thấy người mượn cần xóa!', 'error');
            return redirect()->route('quanlymuonsach.getQuanLyMuonSach');
        }

        // Nếu bảng chi tiết có quan hệ một - nhiều với MuonSach
        $muonsach->details()->delete(); // Xóa các bản ghi chi tiết liên quan

        // Sau khi xóa chi tiết, tiến hành xóa bản ghi chính
        try {
            $muonsach->delete();
        } catch (\Exception $e) {
            // Xu ly loi
            return redirect()->back()->with('error', 'Có lỗi xảy ra không thể xóa!');
        }

        // Gửi thông báo thành công sau khi xóa
        $this->notificationService->addNotification('Người mượn sách và các chi tiết liên quan đã được xóa thành công!', 'success');

        // Điều hướng về trang quản lý
        return redirect()->route('quanlymuonsach.getQuanLyMuonSach');
    }


    public function getAPIMuonSach(Request $request)
    {
        try {
            // Lấy tham số tìm kiếm
            $search = $request->input('search', '');

            // Lấy danh sách sách, lọc theo từ khóa và số lượng sách > 0
            $khosach = KhoSach::when($search, function ($query, $search) {
                return $query->where('tenSach', 'like', '%' . $search . '%');
            })
                ->where('soLuong', '>', 0) // Chỉ lấy sách có số lượng lớn hơn 0
                ->get();

            // Trả về danh sách sách dạng JSON
            return response()->json($khosach, 200);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lấy danh sách sách.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMuonSachDetailApi($id)
    {
        // Sử dụng đúng tên quan hệ 'details' thay vì 'chiTietMuonSach'
        $thongTinMuonSach = MuonSach::with(['details.sach'])->find($id);
    
        if (!$thongTinMuonSach) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin mượn sách.',
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'data' => $thongTinMuonSach,
        ]);
    }

    private function generateMaMuonSach()
    {
        do {
            // Tạo mã sách ngẫu nhiên 8 số
            $maSach = 'MMS' . random_int(10000000, 99999999); // Ví dụ: MS12345678
        } while (MuonSach::where('maMuonSach', $maSach)->exists()); // Kiểm tra xem mã sách đã tồn tại chưa

        return $maSach; // Trả về mã sách duy nhất
    }
}
