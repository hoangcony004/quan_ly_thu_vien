<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class NotificationService
{
    /**
     * Thêm thông báo vào session
     *
     * @param string $message Nội dung thông báo
     * @param string $type Loại thông báo (success, error, info, warning, ...)
     */
    public function addNotification($message, $type)
    {
        // Lấy thông báo hiện tại từ session
        $notifications = Session::get('notifications', []);

        // Thêm thông báo mới vào mảng
        $notifications[] = [
            'message' => $message,
            'type' => $type,
            'created_at' => now()->toDateTimeString(),
        ];

        session()->flash('toast_message', $message);
        session()->flash('toast_type', $type);

        // Giới hạn số lượng thông báo
        if (count($notifications) > 100) {
            array_shift($notifications); // Xóa thông báo cũ nhất
        }

        // Cập nhật lại session
        Session::put('notifications', $notifications);
    }

    /**
     * Lấy danh sách thông báo và tự động xóa những thông báo đã hết hạn.
     *
     * @param int $expiryMinutes Thời gian tồn tại của thông báo (mặc định 60 phút)
     * @return array Danh sách thông báo còn hợp lệ
     */
    public function getNotifications($expiryMinutes = 60)
    {
        // Lấy danh sách thông báo từ session
        $notifications = Session::get('notifications', []);

        // Lọc thông báo còn hiệu lực
        $validNotifications = array_filter($notifications, function ($notification) use ($expiryMinutes) {
            return now()->diffInMinutes($notification['created_at']) <= $expiryMinutes;
        });

        // Cập nhật lại session chỉ với những thông báo còn hợp lệ
        Session::put('notifications', $validNotifications);

        return $validNotifications;
    }

    /**
     * Xóa tất cả thông báo
     */
    public function clearNotifications()
    {
        Session::forget('notifications');
    }
}
