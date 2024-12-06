<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalLabel">Chi Tiết Mượn Sách</h4>
        </div>
        <div class="modal-body">
            <div id="modalContent">
                <!-- Nội dung sẽ được tải bằng Ajax -->
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btn-view').on('click', function() {
            var id = $(this).data('id'); // Lấy ID của bản ghi

            // Lấy token từ localStorage hoặc sessionStorage
            var token = document.querySelector('meta[name="jwt-token"]').getAttribute('content');

            // Gọi API để lấy dữ liệu với token trong header
            fetch('/api/muon-sach/show/' + id, {
                method: 'GET', // Phương thức GET
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token // Thêm token vào header Authorization
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hiển thị dữ liệu trong modal
                        let muonSach = data.data;

                        // Kiểm tra và chuyển trangThai sang kiểu số (nếu nó là chuỗi)
                        let trangThaiValue = parseInt(muonSach.trangThai);

                        // Mô tả trạng thái dựa trên giá trị của trangThai
                        let trangThaiDescription = '';
                        let trangThaiClass = '';

                        switch(trangThaiValue) {
                            case 1:
                                trangThaiDescription = "Đã Mượn";
                                trangThaiClass = "text-success"; // Màu xanh cho trạng thái "Đã Mượn"
                                break;
                            case 2:
                                trangThaiDescription = "Đã Trả";
                                trangThaiClass = "text-primary"; // Màu xanh dương cho trạng thái "Đã Trả"
                                break;
                            case 3:
                                trangThaiDescription = "Quá Hạn Trả";
                                trangThaiClass = "text-danger"; // Màu đỏ cho trạng thái "Quá Hạn"
                                break;
                            case 4:
                                trangThaiDescription = "Chưa Nghĩa Ra";
                                trangThaiClass = "text-warning"; // Màu vàng cho trạng thái "Chưa Nghĩa Ra"
                                break;
                            case 5:
                                trangThaiDescription = "Đã Hủy";
                                trangThaiClass = "text-muted"; // Màu xám cho trạng thái "Đã Hủy"
                                break;
                            default:
                                trangThaiDescription = "Không Xác Định";
                                trangThaiClass = "text-secondary"; // Màu xám cho trạng thái "Không xác định"
                        }

                        let html = `
                        <div class="row">
                            <!-- Thông Tin Người Mượn -->
                            <div class="col-md-4">
                                <h3>Thông Tin Người Mượn</h3>
                                <p><strong>Tên:</strong> ${muonSach.tenNguoiMuon}</p>
                                <p><strong>Email:</strong> ${muonSach.email}</p>
                                <p><strong>Số Điện Thoại:</strong> ${muonSach.soDienThoai}</p>
                                <p><strong>Ngày Mượn:</strong> ${muonSach.ngayMuon}</p>
                                <p><strong>Ngày Trả:</strong> ${muonSach.ngayTra}</p>
                                <p><strong>Trạng Thái:</strong> <span class="${trangThaiClass}">${trangThaiDescription}</span></p>
                            </div>

                            <!-- Chi Tiết Sách Mượn -->
                            <div class="col-md-8">
                                <h3>Chi Tiết Sách Mượn</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên Sách</th>
                                            <th>Số Lượng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;

                        // Duyệt qua các chi tiết sách mượn
                        muonSach.details.forEach((item, index) => {
                            html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.sach.tenSach}</td>
                                <td>${item.soLuong}</td>
                            </tr>
                        `;
                        });

                        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
                `;

                        // Gắn HTML vào modal
                        $('#modalContent').html(html);

                        // Hiển thị modal
                        $('#viewMuonSachModal').modal('show');
                    } else {
                        alert(data.message || 'Không thể tải thông tin. Vui lòng thử lại!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã xảy ra lỗi khi gọi API.');
                });
        });
    });
</script>



