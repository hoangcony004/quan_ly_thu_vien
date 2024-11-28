@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tác Giả</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="active">
                <strong>Danh Sách Tác Giả</strong>
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
                <i class="fa fa-plus-circle"></i> Thêm Tác Giả
            </button>
            <div class="ibox-title">
                <h5>Danh Sách Tác Giả</h5>
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
                    @if($tacgiaList->isEmpty())
                    <br>
                    <p style="display: flex; justify-content: center; font-size: 28px; color: red;">Không tìm thấy tác
                        giả
                        nào
                        với
                        tên
                        '{{ $query }}'.</p>
                    @else
                    <table class="table table-striped">
                        <thead>
                            <tr>

                                <th>STT</th>
                                <th>Họ Tên Tác Giả </th>
                                <th>Ngày Sinh </th>
                                <th>Ngày Mất</th>
                                <th>Trạng Thái</th>
                                <th>Mô Tả</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tacgiaList as $index => $tacgia)
                            <tr>
                                <td>{{ $tacgiaList->firstItem() + $index }}</td>
                                <td>{{ $tacgia->tenTacGia }}</td>
                                <td>{{ \Carbon\Carbon::parse($tacgia->ngaySinh)->format('d/m/Y') }}</td>
                                <td>@if (empty($tacgia->ngayMat))
                                    Chưa cập nhật
                                    @else
                                    {{ \Carbon\Carbon::parse($tacgia->ngayMat)->format('d/m/Y') }}
                                    @endif
                                </td>
                                <td>
                                    <input type="checkbox" class="js-switch" name="trangThai" id="id_switch"
                                        {{ $tacgia->trangThai ? 'checked' : '' }} />
                                </td>

                                <td>
                                    {{ empty($tacgia->moTa) ? 'Không có mô tả' : (strlen($tacgia->moTa) > 50 ? substr($tacgia->moTa, 0, 50) . '...' : $tacgia->moTa) }}
                                </td>

                                <td>
                                    <a href="{{ route('tacgia.getEditTacGia', ['id' => $tacgia->id]) }}"
                                        class="icon-link"><i class="fa fa-pencil-square"
                                            style="color: black; font-size: 18px"></i></a>

                                    <a href="#" class="icon-link" style="color: red; font-size: 18px"
                                        data-toggle="modal" data-target="#myModal4" data-id="{{ $tacgia->id }}"><i
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
                    {{ $tacgiaList->appends(['query' => request()->query('query')])->links() }}
                </div>
                @else
                <!-- Nếu không có tham số query, sử dụng phân trang mặc định của bạn -->
                <div style="display: flex; justify-content: center;">
                    <x-pagination :paginator="$tacgiaList" />
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true">
    @include('admin.partials.tacgia.form-add-tac-gia')
</div>

<div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">
    @include('admin.partials.tacgia.form-delete-tac-gia')

</div>
@endsection