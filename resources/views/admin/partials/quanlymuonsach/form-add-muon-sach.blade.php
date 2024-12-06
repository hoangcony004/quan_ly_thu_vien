<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
            <h4 class="modal-title">Thêm Thông Tin Mượn Sách</h4>
            <small class="font-bold">Vui lòng nhập đầy đủ các thông tin.</small>
        </div>
        <form action="{{ route('quanlymuonsach.postAddMuonSach') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Họ Tên Người Mượn</label>
                            <input type="text" class="form-control" id="inputName" name="tenNguoiMuon" required
                                placeholder="Nhập tên người mượn..." value="{{ old('tenNguoiMuon') }}" autofocus>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tổng Số Lượng</label>
                            <input
                                type="number"
                                class="form-control"
                                id="inputSoLuong"
                                name="soLuong"
                                required
                                placeholder="Nhập tổng số lượng (Không quá 10)..."
                                value="{{ old('soLuong', 1) }}"
                                min="1"
                                max="10">
                        </div>
                    </div><br>
                </div>

                <div class="mb-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label for="inputNgaySinh" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="inputName" required
                                placeholder="Nhập email..." value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="inputNgayMat" class="form-label">Số Điện Thoại</label>
                            <input type="number" class="form-control" name="soDienThoai" id="inputName"
                                placeholder="Nhập số điện thoại..." value="{{ old('soDienThoai') }}">
                        </div>
                    </div>
                </div><br>

                <div class="mb-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label for="inputNgaySinh" class="form-label">Ngày Mượn</label>
                            <input type="date" class="form-control" name="ngayMuon" id="inputName" required
                                placeholder="Nhập ngày mượn sách..." value="{{ old('ngayMuon') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="inputNgayMat" class="form-label">Ngày Trả</label>
                            <input type="date" class="form-control" name="ngayTra" id="inputName"
                                placeholder="Nhập ngày trả sách..." value="{{ old('ngayTra') }}">
                        </div>
                    </div>
                </div><br>

                <div id="select-container"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </div>
        </form>
        @include('admin.partials.error')
    </div>
</div>
<style>
    #select-container .select-wrapper {
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    #select-container {
        margin-bottom: 1rem;
    }

    #select-container .btn-remove {
        margin-left: 15px;
    }

    .select-wrapper select {
        margin-right: 10px;
        width: calc(100% - 70px);
        /* Đảm bảo select2 chiếm không gian còn lại */
    }

    .select-wrapper .quantity-input {
        width: 60px;
    }
</style>

<script>
    $(document).ready(function() {
        $('#myModal5').on('shown.bs.modal', function() {
            var token = document.querySelector('meta[name="jwt-token"]').getAttribute('content');

            function initializeSelect2(selector) {
                $(selector).select2({
                    placeholder: "Chọn Sách",
                    dropdownParent: $('#myModal5 .modal-content'),
                    ajax: {
                        url: '/api/muon-sach',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.tenSach
                                }))
                            };
                        },
                        cache: true,
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    }
                });
            }

            function clearData() {
                // Xóa dữ liệu trong ô input và container
                $('#inputSoLuong').val('');
                $('#select-container').empty();
            }

            $('#inputSoLuong').on('input', function() {
                var totalQuantity = parseInt($(this).val()) || 0;

                if (totalQuantity > 10) {
                    alert('Bạn đã nhập vượt quá giới hạn cho phép! Vui lòng nhập lại.');
                    clearData(); // Gọi hàm xóa dữ liệu
                    return;
                }

                // Nếu hợp lệ, tạo danh sách select
                $('#select-container').empty();

                for (var i = 1; i <= totalQuantity; i++) {
                    var newSelect = `
                    <div class="select-wrapper mb-2">
                        <select id="selectMuonSach-${i}" class="form-control select-muon-sach" name="maMuon[]" style="width: 95%;" required></select>
                        <input type="number" name="soLuongSach[]" class="form-control quantity-input" placeholder="Số lượng" min="1" max="10" required>
                    </div>`;
                    $('#select-container').append(newSelect);
                    initializeSelect2(`#selectMuonSach-${i}`);
                }

                // Thêm sự kiện kiểm tra số lượng cho các input vừa tạo
                $('.quantity-input').on('input', function() {
                    var value = parseInt($(this).val()) || 1;
                    if (value > 10) {
                        alert('Số lượng tối đa cho mỗi sách là 10!');
                        $(this).val(10);
                    }
                });
            });

            // Kích hoạt sự kiện input lần đầu để render giao diện mặc định
            $('#inputSoLuong').trigger('input');
        });
    });
</script>
