@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">Monthly</span>
                <h5>Income</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">40 886,200</h1>
                <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                <small>Total income</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">Annual</span>
                <h5>Orders</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">275,800</h1>
                <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                <small>New orders</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-primary pull-right">Today</span>
                <h5>visits</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">106,120</h1>
                <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                <small>New visits</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-danger pull-right">Low value</span>
                <h5>User activity</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">80,600</h1>
                <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i>
                </div>
                <small>In first month</small>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Orders</h5>
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-white active">Today</button>
                        <button type="button" class="btn btn-xs btn-white">Monthly</button>
                        <button type="button" class="btn btn-xs btn-white">Annual</button>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <ul class="stat-list">
                            <li>
                                <h2 class="no-margins">2,346</h2>
                                <small>Total orders in period</small>
                                <div class="stat-percent">48% <i class="fa fa-level-up text-navy"></i>
                                </div>
                                <div class="progress progress-mini">
                                    <div style="width: 48%;" class="progress-bar"></div>
                                </div>
                            </li>
                            <li>
                                <h2 class="no-margins ">4,422</h2>
                                <small>Orders in last month</small>
                                <div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i>
                                </div>
                                <div class="progress progress-mini">
                                    <div style="width: 60%;" class="progress-bar"></div>
                                </div>
                            </li>
                            <li>
                                <h2 class="no-margins ">9,180</h2>
                                <small>Monthly income from orders</small>
                                <div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
                                <div class="progress progress-mini">
                                    <div style="width: 22%;" class="progress-bar"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Messages</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content ibox-heading">
                <h3><i class="fa fa-envelope-o"></i> New messages</h3>
                <small><i class="fa fa-tim"></i> You have 22 new messages and 16 waiting in draft
                    folder.</small>
            </div>
            <div class="ibox-content">
                <div class="feed-activity-list">

                    <div class="feed-element">
                        <div>
                            <small class="pull-right text-navy">1m ago</small>
                            <strong>Monica Smith</strong>
                            <div>Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry. Lorem Ipsum</div>
                            <small class="text-muted">Today 5:60 pm - 12.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">2m ago</small>
                            <strong>Jogn Angel</strong>
                            <div>There are many variations of passages of Lorem Ipsum available</div>
                            <small class="text-muted">Today 2:23 pm - 11.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Jesica Ocean</strong>
                            <div>Contrary to popular belief, Lorem Ipsum</div>
                            <small class="text-muted">Today 1:00 pm - 08.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Monica Jackson</strong>
                            <div>The generated Lorem Ipsum is therefore </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>


                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Anna Legend</strong>
                            <div>All the Lorem Ipsum generators on the Internet tend to repeat </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Damian Nowak</strong>
                            <div>The standard chunk of Lorem Ipsum used </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <div>
                            <small class="pull-right">5m ago</small>
                            <strong>Gary Smith</strong>
                            <div>200 Latin words, combined with a handful</div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">

        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>User project list</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-hover no-margins">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><small>Pending...</small></td>
                                    <td><i class="fa fa-clock-o"></i> 11:20pm</td>
                                    <td>Samantha</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 24% </td>
                                </tr>
                                <tr>
                                    <td><span class="label label-warning">Canceled</span> </td>
                                    <td><i class="fa fa-clock-o"></i> 10:40am</td>
                                    <td>Monica</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 66% </td>
                                </tr>
                                <tr>
                                    <td><small>Pending...</small> </td>
                                    <td><i class="fa fa-clock-o"></i> 01:30pm</td>
                                    <td>John</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 54% </td>
                                </tr>
                                <tr>
                                    <td><small>Pending...</small> </td>
                                    <td><i class="fa fa-clock-o"></i> 02:20pm</td>
                                    <td>Agnes</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 12% </td>
                                </tr>
                                <tr>
                                    <td><small>Pending...</small> </td>
                                    <td><i class="fa fa-clock-o"></i> 09:40pm</td>
                                    <td>Janet</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 22% </td>
                                </tr>
                                <tr>
                                    <td><span class="label label-primary">Completed</span> </td>
                                    <td><i class="fa fa-clock-o"></i> 04:10am</td>
                                    <td>Amelia</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 66% </td>
                                </tr>
                                <tr>
                                    <td><small>Pending...</small> </td>
                                    <td><i class="fa fa-clock-o"></i> 12:08am</td>
                                    <td>Damian</td>
                                    <td class="text-navy"> <i class="fa fa-level-up"></i> 23% </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Trạng Thái Mượn Sách</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div>
                            <div id="pie-ti-le-trang-thai-muon-sach"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Transactions worldwide</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div id="stocked"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Token dùng để xác thực API
        var token = document.querySelector('meta[name="jwt-token"]').getAttribute('content');

        // Ánh xạ trạng thái từ số sang tên trạng thái
        const trangThaiMapping = {
            '1': 'Đang mượn',
            '2': 'Đã trả',
            '3': 'Quá hạn',
            '4': 'Đang xử lý',
            '5': 'Hủy'
        };

        // Gọi API lấy dữ liệu
        $.ajax({
            url: '/api/muon-sach/status', // Thay URL bằng URL thực tế
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}` // Thêm token vào header
            },
            dataType: 'json',
            success: function(data) {
                // Xử lý dữ liệu: ánh xạ trạng thái và chuyển thành định dạng biểu đồ
                const columns = data.map(item => [
                    trangThaiMapping[item.trangThai] || 'Không xác định', // Ánh xạ trạng thái
                    item.count
                ]);

                const colors = {
                    'Đang mượn': '#1ab394',
                    'Đã trả': '#BABABA',
                    'Quá hạn': '#f8ac59',
                    'Đang xử lý': '#5a5aad',
                    'Hủy': '#ed5565',
                    'Không xác định': '#d3d3d3'
                };

                // Tạo biểu đồ
                c3.generate({
                    bindto: '#pie-ti-le-trang-thai-muon-sach',
                    data: {
                        columns: columns,
                        colors: colors,
                        type: 'pie'
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error("Lỗi khi gọi API:", error);
            }
        });

        c3.generate({
            bindto: '#stocked',
            data: {
                columns: [
                    ['data1', 30, 200, 100, 400, 150, 250, 1000, 1500, 2000, 1220, 1500, 1800]  ,
                ],
                colors: {
                    data1: '#1ab394'
                },
                type: 'bar',
                groups: [
                    ['data1']
                ]
            }
        });
    });
</script>




@endsection