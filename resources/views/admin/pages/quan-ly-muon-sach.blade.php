@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Đang Mượn Sách</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="active">
                <strong>Đang Mượn Sách</strong>
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
                <i class="fa fa-plus-circle"></i> Thêm Người Mượn
            </button>
            <div class="ibox-title">
                <h5>Đang Mượn Sách</h5>
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
                        <form action="{{ route('tacgia.getTimKiemTacGia') }}" method="get">
                            <div class="input-group">
                                <input type="search" name="query" placeholder="Tìm kiếm..."
                                    class="input-sm form-control">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary"><i
                                            class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div><br>
                </div>
                <div class="table-responsive">
                    @if($muonSachList->isEmpty())
                    <br>
                    <p style="display: flex; justify-content: center; font-size: 28px; color: red;">Không tìm thấy thông tin nào với tên '{{ $query }}'.</p>
                    @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã Mượn Sách</th>
                                <th>Tên Người Mượn Sách</th>
                                <th>Số Điện Thoại</th>
                                <th>Email</th>
                                <th>Tổng Số Lượng</th>
                                <th>Ngày Mượn</th>
                                <th>Ngày Trả</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($muonSachList as $index => $muonsach)
                            <tr>
                                <!-- Checkbox -->
                                <td>
                                    {{ $muonSachList->firstItem() + $index }}
                                </td>

                                <!-- Mã Mượn Sách -->
                                <td>{{ $muonsach->maMuonSach }}</td>

                                <!-- Tên Người Mượn Sách -->
                                <td>{{ $muonsach->tenNguoiMuon }}</td>

                                <!-- Số Điện Thoại -->
                                <td>{{ $muonsach->soDienThoai }}</td>

                                <!-- Email -->
                                <td>{{ $muonsach->email }}</td>

                                <!-- Tổng Số Lượng -->
                                <td>Đang mượn {{ $muonsach->soLuong }} sách</td>

                                <!-- Ngày Mượn -->
                                <td>{{ \Carbon\Carbon::parse($muonsach->ngayMuon)->format('d-m-Y') }}</td>

                                <!-- Ngày Trả -->
                                <td>{{ \Carbon\Carbon::parse($muonsach->ngayTra)->format('d-m-Y') }}</td>

                                <!-- Action -->
                                <td>
                                    <a href="#"
                                        class="icon-link btn-view" data-toggle="modal" data-target="#myModalShow" data-id="{{ $muonsach->id }}"><i class="fa fa-eye"
                                            style="color: black; font-size: 18px"></i></a>
                                    <a href=""
                                        class="icon-link"><i class="fa fa-pencil-square"
                                            style="color: black; font-size: 18px"></i></a>

                                    <a href="#" class="icon-link" style="color: red; font-size: 18px"
                                        data-toggle="modal" data-target="#myModal4" data-id="{{ $muonsach->id }}"><i
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
                    {{ $muonSachList->appends(['query' => request()->query('query')])->links() }}
                </div>
                @else
                <!-- Nếu không có tham số query, sử dụng phân trang mặc định của bạn -->
                <div style="display: flex; justify-content: center;">
                    <x-pagination :paginator="$muonSachList" />
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="myModalShow" tabindex="-1" role="dialog" aria-hidden="true">
    @include('admin.partials.quanlymuonsach.form-show-muon-sach')
</div>

<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true">
    @include('admin.partials.quanlymuonsach.form-add-muon-sach')
</div>

<div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">
    @include('admin.partials.quanlymuonsach.form-delete-muon-sach')

</div>
@endsection