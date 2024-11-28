<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#">
            <i class="fa fa-bars"></i>
        </a>
        <!-- Form tìm kiếm -->
        <form role="search" class="navbar-form-custom d-block" id="searchForm" action="{{ route('admin.Search') }}">
            <div class="form-group" style="display: flex; align-items: center; gap: 5px;">
                <input type="search" placeholder="Tìm kiếm chức năng..." class="form-control" name="query"
                    id="top-search" style="flex: 1;">
                <button type="button" id="mic-button" style="background-color: transparent; border: none;">
                    <i class="fa fa-microphone" style="font-size: 20px;"></i>
                </button>
            </div>
        </form>
    </div>
    <style>
        #searchForm {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            /* Nếu có position absolute hoặc fixed */
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const micButton = document.getElementById("mic-button");
            const inputField = document.getElementById("top-search");
            const form = document.getElementById("searchForm");

            // Kiểm tra hỗ trợ Speech Recognition
            if (!("webkitSpeechRecognition" in window || "SpeechRecognition" in window)) {
                alert("Trình duyệt không hỗ trợ chức năng nhận diện giọng nói.");
                return;
            }

            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();
            recognition.lang = "vi-VN"; // Thiết lập ngôn ngữ tiếng Việt
            recognition.interimResults = false; // Không lấy kết quả tạm thời
            recognition.maxAlternatives = 1; // Giới hạn số lượng kết quả trả về

            // Xử lý khi nút mic được nhấn
            micButton.addEventListener("click", function() {
                recognition.start(); // Bắt đầu thu âm
            });

            recognition.onresult = function(event) {
                let transcript = event.results[0][0].transcript; // Lấy kết quả
                transcript = transcript.trim(); // Loại bỏ khoảng trắng ở đầu/cuối

                // Kiểm tra và xử lý dấu chấm cuối chuỗi
                if (transcript.endsWith(".")) {
                    transcript = transcript.slice(0, -1); // Cắt bỏ dấu chấm cuối
                }
                inputField.value = transcript; // Gán kết quả vào ô input

                // Tự động submit form sau khi gán giá trị vào input
                form.submit(); // Thực hiện submit form
            };

            // Xử lý lỗi khi gặp sự cố trong nhận diện giọng nói
            recognition.onerror = function(event) {
                console.error("Lỗi nhận diện giọng nói:", event.error);
                alert("Không thể nhận diện giọng nói. Vui lòng thử lại.");
            };

            // Xử lý khi nhận diện giọng nói được dừng lại
            recognition.onend = function() {
                console.log("Kết thúc nhận diện giọng nói.");
            };
        });
    </script>

    <ul class="nav navbar-top-links navbar-right d-flex justify-content-end">
        <li>
            <span class="m-r-sm text-muted welcome-message">Xin chào: {{ auth()->user()->name }}</span>
        </li>

        <li class="dropdown">
            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                <i class="fa fa-bell"></i>
                <span class="label label-primary"
                    id="notification-count">{{ count(session('notifications', [])) }}</span>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li class="row">
                    <div class="col-6">
                        <h3>Thông báo</h3>
                    </div>
                    <div class="col-6 text-right">
                        <!-- Nút xóa tất cả -->
                        <a href="javascript:void(0);" class="text-danger" style="cursor: pointer;"
                            id="clear-notifications">
                            <i class="fa fa-trash fa-fw"></i> Xóa tất cả
                        </a>
                    </div>
                </li>
                <li class="divider"></li>

                {{-- Debugging thông báo --}}
                @php
                $notifications = session('notifications', []);
                $notificationsToShow = array_slice($notifications, 0, 5); // Chỉ lấy 5 thông báo đầu tiên
                @endphp

                @if (!empty($notificationsToShow) && count($notificationsToShow) > 0)
                @foreach (array_reverse($notificationsToShow) as $notification) {{-- Đảo ngược thứ tự --}}
                @php
                // Đặt màu sắc tương ứng với từng loại thông báo
                $notificationType = $notification['type'] ?? 'info'; // Mặc định là 'info'
                $typeClass = '';
                switch ($notificationType) {
                case 'success':
                $typeClass = 'alert-success'; // Màu xanh lá
                break;
                case 'error':
                $typeClass = 'alert-danger'; // Màu đỏ
                break;
                case 'warning':
                $typeClass = 'alert-warning'; // Màu vàng
                break;
                case 'info':
                $typeClass = 'alert-info'; // Màu xanh dương
                break;
                default:
                $typeClass = 'alert-info'; // Mặc định màu xanh dương
                break;
                }
                @endphp
                <li class="sidebar-message {{ $typeClass }}">
                    <a href="#">
                        <div>
                            <i class="fa fa-info-circle fa-fw"></i>
                            {{ $notification['message'] }}
                            <span class="pull-right text-muted small">
                                {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                            </span>
                        </div>
                    </a>
                </li>
                <li class="divider"></li>
                <br>
                @endforeach
                @else
                <li>
                    <div class="text-center">
                        <strong>Không có thông báo</strong>
                    </div>
                </li>
                @endif

                <br>
                <li>
                    <div class="text-center link-block">
                        <a class="right-sidebar-toggle">Xem tất cả
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </li>
            </ul>
        </li>

        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            document.getElementById('clear-notifications').addEventListener('click', function() {
                // Gửi POST request để xóa thông báo
                axios.post("{{ route('clear.notifications') }}")
                    .then(function(response) {
                        // Cập nhật lại giao diện trong dropdown
                        document.getElementById('notification-count').textContent = response.data
                            .notifications_count;

                        // Cập nhật số lượng thông báo trong tab "Xem tất cả"
                        document.getElementById('notification-count-tab').textContent = response.data
                            .notifications_count;

                        // Cập nhật giao diện trong dropdown menu
                        var notificationList = document.querySelector('.dropdown-menu.dropdown-alerts');
                        notificationList.innerHTML =
                            '<li><div class="text-center"><strong>Không có thông báo</strong></div></li>';

                        // Cập nhật giao diện trong tab "Xem tất cả"
                        var allNotificationsList = document.getElementById('all-notifications-list');
                        allNotificationsList.innerHTML =
                            '<br><div class="text-center"><strong>Không có thông báo</strong></div>';

                    })
                    .catch(function(error) {
                        // Xử lý lỗi
                        console.log(error);
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                    });
            });
        </script>

        <li>
            <a class="right-sidebar-toggle">
                <i class="fa fa-tasks"></i>
            </a>
        </li>

        <li>
            <a href="{{ route('auth.getLogout') }}" class="logout-link">
                <i class="fa fa-sign-out"></i>
                <span class="logout-text">Logout</span>
            </a>
        </li>

    </ul>
    <style>
        .navbar-top-links {
            display: flex;
            /* Sử dụng Flexbox */
            justify-content: flex-end;
            /* Đẩy các phần tử sang phải */
            align-items: center;
            /* Căn giữa theo chiều dọc */
        }

        .navbar-top-links li {
            margin-left: 7px;
            /* Khoảng cách giữa các mục */
        }

        .logout-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
            /* Khoảng cách giữa icon và chữ */
            color: #333;
            text-decoration: none;
        }

        .logout-text {
            display: none;
            /* Ẩn chữ mặc định */
            font-size: 14px;
        }

        .logout-link:hover .logout-text {
            display: inline-block;
            /* Hiển thị chữ khi di chuột */

        }
    </style>

</nav>