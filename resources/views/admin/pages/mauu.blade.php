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
                        <form action="" method="get">
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
                    <table class="table table-striped">
                        <thead>
                            <tr>

                                <th></th>
                                <th>Project </th>
                                <th>Completed </th>
                                <th>Task</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" checked class="i-checks" name="input[]"></td>
                                <td>Project<small>This is example of project</small></td>
                                <td><span class="pie">0.52/1.561</span></td>
                                <td>20%</td>
                                <td>Jul 14, 2013</td>
                                <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                <td>Alpha project</td>
                                <td><span class="pie">6,9</span></td>
                                <td>40%</td>
                                <td>Jul 16, 2013</td>
                                <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                <td>Betha project</td>
                                <td><span class="pie">3,1</span></td>
                                <td>75%</td>
                                <td>Jul 18, 2013</td>
                                <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                <td>Gamma project</td>
                                <td><span class="pie">4,9</span></td>
                                <td>18%</td>
                                <td>Jul 22, 2013</td>
                                <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true">
    @include('admin.partials.tacgia.form-add-tac-gia')
</div>
@endsection