<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificationService;

class SearchController extends Controller
{
    protected $title;

    protected $notificationService; // Khai báo service thông báo

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService; // Khởi tạo service thông báo
    }

    public function index(Request $request)
    {
        // Khai báo title
        $this->title = 'Admin - Tìm Kiếm Chức Năng';

        // Lấy từ khóa tìm kiếm và chuyển thành chữ thường, không dấu
        $query = $this->convertToNonAccent(strtolower($request->input('query')));

        // Đọc dữ liệu từ file JSON
        $data = json_decode(Storage::get('chucnang.json'), true);

        // Kiểm tra nếu từ khóa là "all" hoặc "tất cả"
        if ($query === 'all' || $query === 'tat ca' || $query === 'tất cả') {
            // Lấy toàn bộ danh sách chức năng
            $results = $data[0];
        } else {
            // Lọc các chức năng dựa trên từ khóa tìm kiếm không phân biệt hoa thường và không dấu
            $results = array_filter($data[0], function ($chucNang) use ($query) {
                // Kiểm tra từng phần tử
                if (!is_array($chucNang) || !isset($chucNang['ten']) || !isset($chucNang['moTa'])) {
                    return false; // Bỏ qua các phần tử không hợp lệ
                }

                // Chuyển tên và mô tả thành không dấu, chữ thường
                $ten = $this->convertToNonAccent(strtolower($chucNang['ten']));
                $moTa = $this->convertToNonAccent(strtolower($chucNang['moTa']));

                // So sánh từ khóa với tên và mô tả
                return stripos($ten, $query) !== false || stripos($moTa, $query) !== false;
            });
        }

        // Thêm thông báo
        $this->notificationService->addNotification('Tìm kiếm chức năng hệ thống thành công!', 'success');

        // Trả về view với kết quả tìm kiếm
        return view('admin.pages.search-chuc-nang', [
            'results' => $results,
            'title' => $this->title,
            'query' => $request->input('query') // Để hiển thị đúng từ khóa mà người dùng nhập
        ]);
    }



    // Hàm chuyển chuỗi có dấu thành không dấu
    private function convertToNonAccent($str)
    {
        $unwantedArray = [
            'à' => 'a',
            'á' => 'a',
            'ạ' => 'a',
            'ả' => 'a',
            'ã' => 'a',
            'â' => 'a',
            'ầ' => 'a',
            'ấ' => 'a',
            'ậ' => 'a',
            'ẩ' => 'a',
            'ẫ' => 'a',
            'ă' => 'a',
            'ằ' => 'a',
            'ắ' => 'a',
            'ặ' => 'a',
            'ẳ' => 'a',
            'ẵ' => 'a',
            'è' => 'e',
            'é' => 'e',
            'ẹ' => 'e',
            'ẻ' => 'e',
            'ẽ' => 'e',
            'ê' => 'e',
            'ề' => 'e',
            'ế' => 'e',
            'ệ' => 'e',
            'ể' => 'e',
            'ễ' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'ị' => 'i',
            'ỉ' => 'i',
            'ĩ' => 'i',
            'ò' => 'o',
            'ó' => 'o',
            'ọ' => 'o',
            'ỏ' => 'o',
            'õ' => 'o',
            'ô' => 'o',
            'ồ' => 'o',
            'ố' => 'o',
            'ộ' => 'o',
            'ổ' => 'o',
            'ỗ' => 'o',
            'ơ' => 'o',
            'ờ' => 'o',
            'ớ' => 'o',
            'ợ' => 'o',
            'ở' => 'o',
            'ỡ' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'ụ' => 'u',
            'ủ' => 'u',
            'ũ' => 'u',
            'ư' => 'u',
            'ừ' => 'u',
            'ứ' => 'u',
            'ự' => 'u',
            'ử' => 'u',
            'ữ' => 'u',
            'ỳ' => 'y',
            'ý' => 'y',
            'ỵ' => 'y',
            'ỷ' => 'y',
            'ỹ' => 'y',
            'đ' => 'd',
            'À' => 'A',
            'Á' => 'A',
            'Ạ' => 'A',
            'Ả' => 'A',
            'Ã' => 'A',
            'Â' => 'A',
            'Ầ' => 'A',
            'Ấ' => 'A',
            'Ậ' => 'A',
            'Ẩ' => 'A',
            'Ẫ' => 'A',
            'Ă' => 'A',
            'Ằ' => 'A',
            'Ắ' => 'A',
            'Ặ' => 'A',
            'Ẳ' => 'A',
            'Ẵ' => 'A',
            'È' => 'E',
            'É' => 'E',
            'Ẹ' => 'E',
            'Ẻ' => 'E',
            'Ẽ' => 'E',
            'Ê' => 'E',
            'Ề' => 'E',
            'Ế' => 'E',
            'Ệ' => 'E',
            'Ể' => 'E',
            'Ễ' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Ị' => 'I',
            'Ỉ' => 'I',
            'Ĩ' => 'I',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ọ' => 'O',
            'Ỏ' => 'O',
            'Õ' => 'O',
            'Ô' => 'O',
            'Ồ' => 'O',
            'Ố' => 'O',
            'Ộ' => 'O',
            'Ổ' => 'O',
            'Ỗ' => 'O',
            'Ơ' => 'O',
            'Ờ' => 'O',
            'Ớ' => 'O',
            'Ợ' => 'O',
            'Ở' => 'O',
            'Ỡ' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Ụ' => 'U',
            'Ủ' => 'U',
            'Ũ' => 'U',
            'Ư' => 'U',
            'Ừ' => 'U',
            'Ứ' => 'U',
            'Ự' => 'U',
            'Ử' => 'U',
            'Ữ' => 'U',
            'Ỳ' => 'Y',
            'Ý' => 'Y',
            'Ỵ' => 'Y',
            'Ỷ' => 'Y',
            'Ỹ' => 'Y',
            'Đ' => 'D'
        ];
        return strtr($str, $unwantedArray);
    }
}
