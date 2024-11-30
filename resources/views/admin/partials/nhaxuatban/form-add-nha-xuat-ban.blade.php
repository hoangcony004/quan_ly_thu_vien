<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
            <h4 class="modal-title">Thêm Nhà Xuất Bản</h4>
            <small class="font-bold">Vui lòng nhập các thông tin của nhà xuất bản.</small>
        </div>
        <form action="{{ route('nhaxuatban.postAddNhaXuatBan') }}" method="post">
            @csrf
            <div class="modal-body">
                <!-- Các ô input điền thông tin -->
                <div class="mb-3">

                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Tên Nhà Xuất Bản</label>
                            <input type="text" class="form-control" id="inputName" name="tenNhaXuatBan" required
                                placeholder="Nhập tên nhà xuất bản...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Trạng Thái: </label><br>
                            <input type="checkbox" class="js-switch " name="trangThai" id="id_switch" checked />
                        </div>
                    </div>
                </div><br>

                <div class="mb-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label class="form-label">Số Điện Thoại</label>
                            <input type="number" class="form-control" name="soDienThoai" required
                                placeholder="Nhập số điện thoại...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                placeholder="Nhập email..." require>
                        </div>
                    </div>
                </div><br>

                <div class="mb-3">
                    <label for="inputName" class="form-label">Địa Chỉ</label>
                    <textarea class="form-control" name="diaChi"
                        placeholder="Nhập địa chỉ..."></textarea>
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