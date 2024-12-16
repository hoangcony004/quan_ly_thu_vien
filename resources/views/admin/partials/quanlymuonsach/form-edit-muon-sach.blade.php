@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <a href="javascript:history.back()" class="btn btn-info">
                <i class="fa fa-chevron-circle-left"></i> Quay lại
            </a>
            <div class="ibox-title">
                <h5>Sửa Thể Loại</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form action="{{ route('quanlymuonsach.postEditMuonSach', $quanlymuonsach->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <!-- Thông tin người mượn -->
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Họ Tên Người Mượn</label>
                            <input type="text" class="form-control" id="inputName" name="tenNguoiMuon" required
                                value="{{ old('tenNguoiMuon', $quanlymuonsach->tenNguoiMuon) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tổng Số Lượng</label>
                            <input type="number" class="form-control" id="inputSoLuong" name="soLuong" required
                                value="{{ old('soLuong', $quanlymuonsach->soLuong) }}" min="1" max="10">
                        </div>
                    </div>

                    <!-- Sách đã mượn -->
                    <div id="select-container">

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                    </div>
                </form>

                @include('admin.partials.error')
                <div id="data-container" data-chi-tiet-muon-sach='{{ json_encode($quanlymuonsach->details ?? []) }}'></div>
            </div>
        </div>
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
        let dataContainer = document.getElementById('data-container');
        let chiTietMuonSach = JSON.parse(dataContainer.getAttribute('data-chi-tiet-muon-sach'));
        console.log(chiTietMuonSach); // Kiểm tra dữ liệu


        chiTietMuonSach.forEach((item, index) => {
            // Tạo option mặc định cho sách đã chọn
            let selectedSach = {
                id: item.sach_id,
                text: item.sach.tenSach
            };

            // Tạo HTML cho mỗi sách đã chọn
            let newSelect = `
                <div class="select-wrapper mb-2">
                    <select id="selectMuonSach-${index + 1}" class="form-control select-muon-sach" name="maMuon[]" style="width: 95%;" required>
                    </select>
                    <input type="number" name="soLuongSach[]" class="form-control quantity-input"
                           placeholder="Số lượng" value="${item.soLuongSach}" min="1" max="10" required>
                </div>
            `;

            $('#select-container').append(newSelect);

            // Gán dữ liệu sách vào select2
            $(`#selectMuonSach-${index + 1}`)
                .append(new Option(selectedSach.text, selectedSach.id, true, true))
                .trigger('change')
                .select2({
                    placeholder: "Chọn Sách",
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
                            Authorization: `Bearer ${$('meta[name="jwt-token"]').attr('content')}`
                        }
                    }
                });
        });
    });
</script>


@endsection