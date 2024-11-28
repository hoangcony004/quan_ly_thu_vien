@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Danh Sách Chức Năng Hệ Thống</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="active">
                <strong>Danh Sách Chức Năng</strong>
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
            <a href="javascript:history.back()" class="btn btn-info">
                <i class="fa fa-chevron-circle-left"></i> Quay lại
            </a>
            <div class="ibox-title">
                <h5>Danh Sách Chức Năng</h5>
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
                <style>
                button.btn {
                    background-color: transparent;
                    /* Xóa màu nền */
                    border: none;
                    /* Xóa viền */
                    padding: 0;
                    /* Bỏ padding nếu cần */
                    color: inherit;
                    /* Giữ màu chữ giống thẻ cha */
                    box-shadow: none;
                    /* Loại bỏ bóng đổ nếu có */
                    font-size: 24px;
                    color: #0000ff;
                    /* Màu chữ mặc định */
                    outline: none;
                    /* Xóa viền khi click */
                }

                button.btn:hover {
                    cursor: pointer;
                    /* Thêm con trỏ khi hover */
                    color: #ff0000;
                    /* Màu chữ khi hover */
                }

                button.btn:focus {
                    outline: none;
                    /* Xóa viền focus */
                }

                .function-container {
                    display: flex;
                    flex-wrap: wrap;
                    /* Để các cột tự xuống dòng khi không đủ chỗ */
                    gap: 10px;
                    /* Khoảng cách giữa các cột */
                }

                .column {
                    flex: 1 1 100%;
                    /* Mỗi cột chiếm 100% chiều rộng trên màn hình nhỏ */
                    min-width: 200px;
                    /* Đặt chiều rộng tối thiểu */
                }

                @media (min-width: 768px) {
                    .column {
                        flex: 1 1 calc(33.33% - 10px);
                        /* Mỗi cột chiếm 1/3 chiều rộng trên màn hình lớn hơn 768px */
                    }
                }
                </style>

                <div class="container">
                    <br><br><br>
                    <h1 style="text-align: center; display: block;">
                        Kết quả tìm kiếm cho: "<span>{{ $query }}</span>"
                    </h1><br>
                    <div class="function-container" style="display: flex; flex-wrap: wrap; gap: 20px;">
                        @if(count($results) > 0)
                        @php
                        // Chuyển đổi mảng $results thành Collection
                        $resultsCollection = collect($results);
                        // Chia danh sách thành các nhóm 10 mục
                        $chunkedResults = $resultsCollection->chunk(10);
                        @endphp

                        @foreach($chunkedResults as $chunkIndex => $chunk)
                        <div class="column" style="flex: 1; min-width: 200px;">
                            @foreach($chunk as $key => $result)
                            <div class="function-item">
                                <span class="number">{{ $chunkIndex * 10 + $key + 1 }}: </span>
                                <button type="button" tabindex="0" class="btn" data-bs-toggle="popover"
                                    data-bs-trigger="hover" data-bs-content="{{ $result['moTa'] }}"
                                    title="{{ $result['ten'] }}"
                                    onclick="window.location.href='{{ url($result['url']) }}'">
                                    {{ $result['ten'] }}
                                </button>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                        @else
                        <br>
                        <h4 style="color: red;">- Không tìm thấy chức năng nào khớp với từ khóa.</h4>
                        @endif
                    </div>
                    <br>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection