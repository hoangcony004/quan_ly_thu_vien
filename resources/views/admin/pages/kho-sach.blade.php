@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Kho Sách</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="active">
                <strong>Kho Sách</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<br>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal5">
                <i class="fa fa-plus-circle"></i> Thêm Sách Mới
            </button>
            <div class="ibox-title">
                <h5>Kho Sách</h5>
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
                <div class="row">
                    <div class="col-sm-5 m-b-xs">
                    </div>
                    <div class="col-sm-4 m-b-xs">
                    </div>
                    <div class="col-sm-3">
                        <form action="{{ route('khosach.getSearchSach') }}" method="get">
                            <div class="">
                                <select name="filter" id="filter">
                                    <option value="maSach">Mã Sách</option>
                                    <option value="tenSach">Tên Sách</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <input type="search" name="query" placeholder="Tìm kiếm..."
                                    class="input-sm form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary"><i
                                            class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <br>
                </div>
                <div class="table-responsive">
                    @if($khoSachList->isEmpty())
                    <br>
                    <p style="display: flex; justify-content: center; font-size: 28px; color: red;">Không tìm thấy sách nào với thông tin '{{ $query }}'.</p>
                    @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã Sách</th>
                                <th class="all">Tên Sách</th>
                                <th>Hình Ảnh</th>
                                <th>Tác Giả</th>
                                <th>Nhà Xuất Bản</th>
                                <th>Thể Loại</th>
                                <th>Số Lượng</th>
                                <th>Mô Tả</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($khoSachList as $index => $khosach)
                            <tr>
                                <!-- Cột STT -->
                                <td>{{ $khoSachList->firstItem() + $index }}</td>

                                <!-- Cột Mã Sách -->
                                <td id="maSach" onclick="copyToClipboard(this)" style="cursor: copy;"><i class="fa fa-copy"></i> {{ $khosach->maSach }}</td>

                                <!-- Cột Tên Sách -->
                                <td>{{ $khosach->tenSach }}</td>

                                <!-- Cót Hình Ảnh -->
                                <td>
                                    <!-- <img src="{{ $khosach->image }}" alt="Không Có Ảnh"
                                        style="max-width: 80px; max-height: 80px;"> -->
                                    <a href="{{ $khosach->image }}" title="Image from Unsplash" data-gallery="">
                                        <img src="{{ $khosach->image }}" style="width: 100px;">
                                    </a>

                                </td>

                                <!-- Cột Tác Giả -->
                                <td>{{ $khosach->tacGia->tenTacGia }}</td>

                                <!-- Cột Nhà Xuất Bản -->
                                <td>{{ $khosach->nhaXuatBan->tenNhaXuatBan }}</td>

                                <!-- Cột Thể Loại -->
                                <td>{{ $khosach->theLoai->tenTheLoai }}</td>

                                <!-- Cót Số Lượng -->
                                <td>{{ $khosach->soLuong }}</td>

                                <!-- Cột Mô Tả -->
                                <td>{{ \Illuminate\Support\Str::limit($khosach->moTa, 50) }}</td>
                                <td>
                                    <a href="{{ route('khosach.getEditSach', ['id' => $khosach->id]) }}"
                                        class="icon-link"><i class="fa fa-pencil-square"
                                            style="color: black; font-size: 18px"></i></a>

                                    <a href="#" class="icon-link" style="color: red; font-size: 18px"
                                        data-toggle="modal" data-target="#myModal4" data-id="{{ $khosach->id }}"><i
                                            class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                <!-- Phân trang -->
                @if (request()->has('query'))
                <!-- Nếu có tham số query, sử dụng phân trang với appends -->
                <div style="display: flex; justify-content: center;">
                    {{ $khoSachList->appends(['query' => request()->query('query')])->links() }}
                </div>
                @else
                <!-- Nếu không có tham số query, sử dụng phân trang mặc định của bạn -->
                <div style="display: flex; justify-content: center;">
                    <x-pagination :paginator="$khoSachList" />
                </div>
                @endif
            </div>
        </div>
    </div>

</div>


@include('admin.partials.khosach.form-add-sach')


<div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">
    @include('admin.partials.khosach.form-delete-sach')

</div>

<script>
    function copyToClipboard(element) {
        // Tạo một textarea ẩn để copy giá trị
        var textArea = document.createElement("textarea");
        textArea.value = element.textContent || element.innerText; // Lấy giá trị của thẻ td
        document.body.appendChild(textArea);

        // Chọn và sao chép giá trị
        textArea.select();
        document.execCommand("copy");

        // Xóa textarea sau khi copy xong
        document.body.removeChild(textArea);

        // Hiển thị thông báo cho người dùng (có thể thay đổi thông báo theo ý thích)
        alert("Mã sách đã được sao chép và lưu vào bộ nhớ đệm: " + textArea.value);
    }
</script>
@endsection