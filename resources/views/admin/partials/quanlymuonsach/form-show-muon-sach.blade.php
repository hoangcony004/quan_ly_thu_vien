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
            var id = $(this).data('id');
            var token = document.querySelector('meta[name="jwt-token"]').getAttribute('content');

            fetch('/api/muon-sach/show/' + id, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let muonSach = data.data;

                        // Kiểm tra và chuyển trangThai sang kiểu số (nếu nó là chuỗi)
                        let trangThaiValue = parseInt(muonSach.trangThai);

                        // Mô tả trạng thái dựa trên giá trị của trangThai
                        let trangThaiDescription = '';
                        let trangThaiClass = '';

                        switch (trangThaiValue) {
                            case 1:
                                trangThaiDescription = "Đang Mượn";
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
                                trangThaiDescription = "Đang Xử Lý";
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

                        // Tạo HTML ban đầu
                        let html = `
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Thông Tin Người Mượn</h3>
                                <p><strong>Tên:</strong> ${muonSach.tenNguoiMuon}</p>
                                <p><strong>Email:</strong> ${muonSach.email ? muonSach.email : 'Chưa cập nhật'}</p>
                                <p><strong>Số Điện Thoại:</strong> ${muonSach.soDienThoai ? muonSach.soDienThoai : 'Chưa cập nhật'}</p>
                                <p><strong>Ngày Mượn:</strong> ${muonSach.ngayMuon}</p>
                                <p><strong>Ngày Trả:</strong> ${muonSach.ngayTra}</p>
                                <p><strong>Trạng Thái:</strong> <span class="${trangThaiClass}">${trangThaiDescription}</span></p>
                            </div>

                            <div class="col-md-8">
                                <h3>Chi Tiết Sách Mượn</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ảnh</th>
                                            <th>Tên Sách</th>
                                            <th>Số Lượng</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bookDetails">
                                        <!-- Nội dung phân trang sẽ chèn vào đây -->
                                    </tbody>
                                </table>
                                <div id="pagination" class="text-center">
                                    <!-- Nút phân trang sẽ chèn vào đây -->
                                </div>
                            </div>
                        </div>
                    `;

                        $('#modalContent').html(html);

                        // Xử lý phân trang
                        const details = muonSach.details; // Danh sách sách
                        const itemsPerPage = 5;
                        let currentPage = 1;

                        function renderTable(page) {
                            const start = (page - 1) * itemsPerPage;
                            const end = start + itemsPerPage;
                            const items = details.slice(start, end);

                            let tableHtml = '';
                            items.forEach((item, index) => {
                                tableHtml += `
                                <tr>
                                    <td>${start + index + 1}</td>
                                    <td><img src="${item.sach.image}" alt="${item.sach.tenSach}" width="50"></td>
                                    <td>${item.sach.tenSach}</td>
                                    <td>${item.soLuong}</td>
                                </tr>
                            `;
                            });

                            $('#bookDetails').html(tableHtml);
                        }

                        function renderPagination() {
                            const totalPages = Math.ceil(details.length / itemsPerPage);
                            let paginationHtml = '';

                            for (let i = 1; i <= totalPages; i++) {
                                paginationHtml += `
                                <button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-default'}" data-page="${i}">
                                    ${i}
                                </button>
                            `;
                            }

                            $('#pagination').html(paginationHtml);
                        }

                        // Gắn sự kiện click vào nút phân trang
                        $('#pagination').on('click', 'button', function() {
                            currentPage = parseInt($(this).data('page'));
                            renderTable(currentPage);
                            renderPagination();
                        });

                        // Hiển thị dữ liệu ban đầu
                        renderTable(currentPage);
                        renderPagination();

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