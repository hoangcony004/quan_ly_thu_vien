<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Thêm Thể Loại</h4>
                <small class="font-bold">Vui lòng nhập các thông tin của thể loại.</small>
            </div>
            <form action="{{ route('khosach.postAddSach') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Các ô input điền thông tin -->
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Tên Sách:</label>
                        <input type="text" class="form-control" id="inputName" name="tenSach" required
                            placeholder="Nhập tên quyển sách...">
                    </div><br>

                    <div class="mb-3">
                        <label for="maTacGia" class="form-label">Tác Giả:</label>
                        <select id="selectTacGia" class="form-control" name="maTacGia" style="width: 100%;" required>
                            <!-- Dữ liệu sẽ được load từ API -->
                        </select>
                    </div><br>

                    <div class="mb-3">
                        <label for="maTheLoai" class="form-label">Thể Loại:</label>
                        <select id="selectTheLoai" class="form-control" name="maTheLoai" style="width: 100%;" required>
                            <!-- Dữ liệu sẽ được load từ API -->
                        </select>
                    </div><br>

                    <div class="mb-3">
                        <label for="maNhaXuatBan" class="form-label">Nhà Xuất Bản:</label>
                        <select id="selectNhaXuatBan" class="form-control" name="maNhaXuatBan" style="width: 100%;" required>
                            <!-- Dữ liệu sẽ được load từ API -->
                        </select>
                    </div><br>


                    <!-- Dòng gồm 2 cột: Ngày Xuất Bản và Số Lượng -->
                    <div class="row">
                        <div class="col-md-4">
                            <label for="ngayXuatBan" class="form-label">Ngày Xuất Bản:</label>
                            <input type="date" class="form-control" id="ngayXuatBan" name="ngayXuatBan" required
                                placeholder="Nhập ngày xuất bản...">
                        </div>
                        <div class="col-md-4">
                            <label for="soLuong" class="form-label">Số Lượng:</label>
                            <input type="number" class="form-control" id="soLuong" name="soLuong" required
                                placeholder="Nhập số lượng...">
                        </div>
                        <div class="col-md-4">
                            <label for="soLuong" class="form-label">Ảnh: </label>
                            <input type="file" class="form-control" id="soLuong" name="image"
                                placeholder="Chọn ảnh...">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="moTa" class="form-label">Mô Tả:</label>
                        <textarea class="form-control" name="moTa" required placeholder="Nhập mô tả về sách (Khoảng 100 từ)..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </form>
            @include('admin.partials.error')
        </div>
    </div>
</div>

<script>
    $('#myModal5').on('shown.bs.modal', function() {
        var token = document.querySelector('meta[name="jwt-token"]').getAttribute('content');
        // console.log('Token:', token);

        // Kiểm tra token hợp lệ
        if (token && token.split('.').length === 3) {
            console.log('Valid JWT token');
        } else {
            console.error('Invalid JWT token');
        }

        // Select2 cho Tác Giả
        $('#selectTacGia').select2({
            placeholder: "Chọn tác giả",
            dropdownParent: $('#myModal5 .modal-content'),
            ajax: {
                url: '/api/tac-gia', // API lấy danh sách tác giả
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term // Term tìm kiếm
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.tenTacGia
                        }))
                    };
                },
                cache: true,
                headers: {
                    Authorization: `Bearer ${token}` // Thêm token vào header
                }
            }
        });

        // Select2 cho Thể Loại
        $('#selectTheLoai').select2({
            placeholder: "Chọn thể loại",
            dropdownParent: $('#myModal5 .modal-content'),
            ajax: {
                url: '/api/the-loai', // API lấy danh sách thể loại
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term // Term tìm kiếm
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.tenTheLoai
                        }))
                    };
                },
                cache: true,
                headers: {
                    Authorization: `Bearer ${token}` // Thêm token vào header
                }
            }
        });

        // Select2 cho Nhà Xuất Bản
        $('#selectNhaXuatBan').select2({
            placeholder: "Chọn nhà xuất bản",
            dropdownParent: $('#myModal5 .modal-content'),
            ajax: {
                url: '/api/nha-xuat-ban', // API lấy danh sách nhà xuất bản
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term // Term tìm kiếm
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.tenNhaXuatBan
                        }))
                    };
                },
                cache: true,
                headers: {
                    Authorization: `Bearer ${token}` // Thêm token vào header
                }
            }
        });
    });
</script>