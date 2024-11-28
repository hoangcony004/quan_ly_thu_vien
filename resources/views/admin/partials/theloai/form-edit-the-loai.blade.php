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
                <form action="{{ route('theloai.postEditTheLoai', ['id' => $theloai->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Các ô input điền thông tin -->
                        <div class="mb-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label for="inputName" class="form-label">Tên Thể loại</label>
                                    <input type="text" class="form-control" id="inputName" name="tenTheLoai" required
                                        placeholder="Nhập tên thể loại..." value="{{ $theloai->tenTheLoai }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Trạng Thái: </label><br>
                                    <input type="checkbox" class="js-switch" name="trangThai" id="id_switch" value="1"
                                        {{ $theloai->trangThai ? 'checked' : '' }} />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button> -->
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection