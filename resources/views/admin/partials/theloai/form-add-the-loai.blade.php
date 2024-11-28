<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
            <h4 class="modal-title">Thêm Thể Loại</h4>
            <small class="font-bold">Vui lòng nhập các thông tin của thể loại.</small>
        </div>
        <form action="{{ route('theloai.postAddTheLoai') }}" method="post">
            @csrf
            <div class="modal-body">
                <!-- Các ô input điền thông tin -->
                <div class="mb-3">

                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Tên Thể loại</label>
                            <input type="text" class="form-control" id="inputName" name="tenTheLoai" required
                                placeholder="Nhập tên thể loại...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Trạng Thái: </label><br>
                            <input type="checkbox" class="js-switch " name="trangThai" id="id_switch" checked />
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>