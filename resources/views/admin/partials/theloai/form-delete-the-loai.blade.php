<div class="modal-dialog">
    <div class="modal-content animated fadeIn">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                    class="sr-only">Close</span></button>
            <i class="fa fa-trash" style="font-size: 40px; color: red"></i>
            <h4 class="modal-title text-danger">Xóa Thể Loại</h4>
            <small>Vui lòng xem kĩ trước khi xóa.</small>
        </div>
        <form id="deleteForm" action="" method="post">
            <div class="modal-body">
                @csrf
                <p class="text-center text-danger font-bold">Bạn có chắc chắn muốn xóa không?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-danger">Xóa</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const modalLinks = document.querySelectorAll('a[data-toggle="modal"]');
    const deleteForm = document.getElementById("deleteForm");

    modalLinks.forEach(link => {
        link.addEventListener("click", function() {
            const id = this.getAttribute("data-id");
            const actionUrl = `{{ route('theloai.postDeleteTheLoai', ':id') }}`.replace(':id',
                id);
            // Đường dẫn API xử lý xóa
            deleteForm.setAttribute("action", actionUrl);
        });
    });
});
</script>