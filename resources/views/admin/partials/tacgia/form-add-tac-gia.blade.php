<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
            <h4 class="modal-title">Thêm Tác Giả</h4>
            <small class="font-bold">Vui lòng nhập các thông tin của tác giả.</small>
        </div>
        <form action="{{ route('tacgia.postAddTacGia') }}" method="post">
            @csrf
            <div class="modal-body">
                <!-- Các ô input điền thông tin -->
                <div class="mb-3">

                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Tên Tác Giả</label>
                            <input type="text" class="form-control" id="inputName" name="tenTacGia" required
                                placeholder="Nhập tên tác giả...">
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
                            <label for="inputNgaySinh" class="form-label">Ngày Sinh</label>
                            <input type="date" class="form-control" name="ngaySinh" id="inputNgaySinh" required
                                placeholder="Nhập ngày sinh...">
                        </div>
                        <div class="col-md-6">
                            <label for="inputNgayMat" class="form-label">Ngày Mất (Nếu tác giả chưa mất thì bỏ
                                trống)</label>
                            <input type="date" class="form-control" name="ngayMat" id="inputNgayMat"
                                placeholder="Nhập ngày mất...">
                        </div>
                    </div>
                </div><br>

                <div class="mb-3">
                    <label for="inputName" class="form-label">Mô tả về tác giả</label>
                    <textarea class="form-control" name="moTa"
                        placeholder="Nhập mô tả về tác giả(Khoảng 100 từ)..."></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>