@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <a href="javascript:history.back()" class="btn btn-info">
                <i class="fa fa-chevron-circle-left"></i> Quay lại
            </a>
            <div class="ibox-title">
                <h5>Sửa Sách</h5>
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
                <form action="{{ route('khosach.postEditSach', ['id' => $khosach->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Các ô input điền thông tin -->
                        <div class="mb-3">
                            <label for="inputName" class="form-label">Tên Sách:</label>
                            <input type="text" class="form-control" id="inputName" name="tenSach" required
                                placeholder="Nhập tên quyển sách..." value="{{ $khosach->tenSach }}">
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
                                    placeholder="Nhập ngày xuất bản..." value="{{ $khosach->ngayXuatBan }}">
                            </div>
                            <div class="col-md-4">
                                <label for="soLuong" class="form-label">Số Lượng:</label>
                                <input type="number" class="form-control" id="soLuong" name="soLuong" required
                                    placeholder="Nhập số lượng..." value="{{ $khosach->soLuong }}">
                            </div>
                            <div class="col-md-4">
                                <label for="image" class="form-label">Ảnh hiện tại:</label>
                                @if($khosach->image)
                                <div class="mb-2">
                                    <img src="{{ $khosach->image }}" alt="Ảnh sách" name="image" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                                @else
                                <p>Không có ảnh</p>
                                @endif
                                <label for="image" class="form-label">Thay đổi ảnh:</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="moTa" class="form-label">Mô Tả:</label>
                            <textarea class="form-control" name="moTa" required placeholder="Nhập mô tả về sách (Khoảng 100 từ)..."> {{ $khosach->moTa }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
                @include('admin.partials.error')
            </div>
        </div>
    </div>
</div>
@if($errors->any())
<div
    style="color: red; margin: 10px 0; padding: 10px; border: 1px solid red; border-radius: 5px; background-color: #ffe6e6;">
    <ul style="margin: 0; padding: 0; list-style: none;">
        @foreach ($errors->all() as $error)
        <li style="margin-bottom: 5px;">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<script>
    $(document).ready(function() {
        // Tác Giả
        let selectedTacGia = {
            id: "{{ $khosach->maTacGia }}",
            text: "{{ $khosach->tacGia->tenTacGia }}"
        };
        $('#selectTacGia').append(new Option(selectedTacGia.text, selectedTacGia.id, true, true)).trigger('change');

        // Thể Loại
        let selectedTheLoai = {
            id: "{{ $khosach->maTheLoai }}",
            text: "{{ $khosach->theLoai->tenTheLoai }}"
        };
        $('#selectTheLoai').append(new Option(selectedTheLoai.text, selectedTheLoai.id, true, true)).trigger('change');

        // Nhà Xuất Bản
        let selectedNhaXuatBan = {
            id: "{{ $khosach->maNhaXuatBan }}",
            text: "{{ $khosach->nhaXuatBan->tenNhaXuatBan  }}"
        };
        $('#selectNhaXuatBan').append(new Option(selectedNhaXuatBan.text, selectedNhaXuatBan.id, true, true)).trigger('change');
    });
</script>

<script>
    $(document).ready(function() {
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
@endsection