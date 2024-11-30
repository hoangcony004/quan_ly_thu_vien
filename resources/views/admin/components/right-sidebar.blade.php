<div class="sidebar-container">

    <ul class="nav nav-tabs navs-2">

        <li class="active"><a data-toggle="tab" href="#tab-1">
                Thông Báo
            </a></li>
        <li><a data-toggle="tab" href="#tab-2">
                Projects
            </a></li>
        <!-- <li class=""><a data-toggle="tab" href="#tab-3">
                <i class="fa fa-gear"></i>
            </a></li> -->
    </ul>

    <div class="tab-content">


        <div id="tab-1" class="tab-pane active">
            <div class="sidebar-title">
                <h2> <i class="fa fa-bell"></i> Thông Báo </h2>
                <small><i class="fa fa-tim"></i> Có tất cả <span
                        id="notification-count-tab">{{ count(session('notifications', [])) }}</span> thông báo</small>
            </div>

            <div id="all-notifications-list">
                {{-- Kiểm tra nếu có thông báo --}}
                @if(count(session('notifications', [])) > 0)
                {{-- Lặp qua tất cả thông báo và hiển thị --}}
                @foreach(array_reverse(session('notifications', [])) as $notification)
                {{-- Đảo ngược thứ tự thông báo --}}
                @php
                // Đặt màu sắc tương ứng với từng loại thông báo
                $notificationType = $notification['type'] ?? 'info'; // Mặc định là 'info'
                $typeClass = '';
                switch ($notificationType) {
                case 'success':
                $typeClass = 'alert-success'; // Màu xanh lá
                break;
                case 'error':
                $typeClass = 'alert-danger'; // Màu đỏ
                break;
                case 'warning':
                $typeClass = 'alert-warning'; // Màu vàng
                break;
                case 'info':
                $typeClass = 'alert-info'; // Màu xanh dương
                break;
                default:
                $typeClass = 'alert-info'; // Mặc định màu xanh dương
                break;
                }
                @endphp
                <div class="sidebar-message {{ $typeClass }}">
                    <a href="#">
                        <div class="media-body">
                            <strong>{{ $notification['message'] }}</strong>
                            <br>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                            </small>
                        </div>
                    </a>
                </div>
                @endforeach
                @else
                <br>
                <div class="text-center">
                    <strong>Không có thông báo</strong>
                </div>
                @endif
            </div>
        </div>

        <div id="tab-2" class="tab-pane">

            <div class="sidebar-title">
                <h3> <i class="fa fa-cube"></i> Latest projects</h3>
                <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
            </div>

            <ul class="sidebar-list">
                <li>
                    <a href="#">
                        <div class="small pull-right m-t-xs">9 hours ago</div>
                        <h4>Business valuation</h4>
                        It is a long established fact that a reader will be distracted.

                        <div class="small">Completion with: 22%</div>
                        <div class="progress progress-mini">
                            <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                        </div>
                        <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="small pull-right m-t-xs">9 hours ago</div>
                        <h4>Contract with Company </h4>
                        Many desktop publishing packages and web page editors.

                        <div class="small">Completion with: 48%</div>
                        <div class="progress progress-mini">
                            <div style="width: 48%;" class="progress-bar"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="small pull-right m-t-xs">9 hours ago</div>
                        <h4>Meeting</h4>
                        By the readable content of a page when looking at its layout.

                        <div class="small">Completion with: 14%</div>
                        <div class="progress progress-mini">
                            <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="label label-primary pull-right">NEW</span>
                        <h4>The generated</h4>
                        <!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
                        There are many variations of passages of Lorem Ipsum available.
                        <div class="small">Completion with: 22%</div>
                        <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="small pull-right m-t-xs">9 hours ago</div>
                        <h4>Business valuation</h4>
                        It is a long established fact that a reader will be distracted.

                        <div class="small">Completion with: 22%</div>
                        <div class="progress progress-mini">
                            <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                        </div>
                        <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="small pull-right m-t-xs">9 hours ago</div>
                        <h4>Contract with Company </h4>
                        Many desktop publishing packages and web page editors.

                        <div class="small">Completion with: 48%</div>
                        <div class="progress progress-mini">
                            <div style="width: 48%;" class="progress-bar"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="small pull-right m-t-xs">9 hours ago</div>
                        <h4>Meeting</h4>
                        By the readable content of a page when looking at its layout.

                        <div class="small">Completion with: 14%</div>
                        <div class="progress progress-mini">
                            <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="label label-primary pull-right">NEW</span>
                        <h4>The generated</h4>
                        <!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
                        There are many variations of passages of Lorem Ipsum available.
                        <div class="small">Completion with: 22%</div>
                        <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                    </a>
                </li>

            </ul>

        </div>

        <!-- <div id="tab-3" class="tab-pane">

            <div class="sidebar-title">
                <h3><i class="fa fa-gears"></i> Settings</h3>
                <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
            </div>

            <div class="setings-item">
                <span>
                    Show notifications
                </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
                        <label class="onoffswitch-label" for="example">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="setings-item">
                <span>
                    Disable Chat
                </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox" id="example2">
                        <label class="onoffswitch-label" for="example2">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="setings-item">
                <span>
                    Enable history
                </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
                        <label class="onoffswitch-label" for="example3">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="setings-item">
                <span>
                    Show charts
                </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
                        <label class="onoffswitch-label" for="example4">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="setings-item">
                <span>
                    Offline users
                </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example5">
                        <label class="onoffswitch-label" for="example5">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="setings-item">
                <span>
                    Global search
                </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example6">
                        <label class="onoffswitch-label" for="example6">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="setings-item">
                <span>
                    Update everyday
                </span>
                <div class="switch">
                    <div class="onoffswitch">
                        <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
                        <label class="onoffswitch-label" for="example7">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="sidebar-content">
                <h4>Settings</h4>
                <div class="small">
                    I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry.
                    And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                    since the 1500s.
                    Over the years, sometimes by accident, sometimes on purpose (injected humour and the
                    like).
                </div>
            </div>

        </div> -->
    </div>
</div>