<div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element"> <span>
                    <img alt="image" class="img-circle" src="{{ auth()->user()->image }}" style="width: 40px;" />
                </span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear">
                        <span class="block m-t-xs"> <strong class="font-bold">{{ auth()->user()->name }}</strong>
                        </span>
                        <span class="text-muted text-xs block">
                            @if(auth()->user()->role == 1)
                            Quản trị viên
                            @elseif(auth()->user()->role == 2)
                            Người quản lý
                            @elseif(auth()->user()->role == 3)
                            Nhân viên
                            @elseif(auth()->user()->role == 4)
                            Khách hàng
                            @elseif(auth()->user()->role == 5)
                            Khách vãng lai
                            @else
                            Không xác định
                            @endif
                            <b class="caret"></b>
                        </span>

                    </span>
                </a>
                <ul class="dropdown-menu animated fadeInLeft m-t-xs">
                    <li><a href="profile.html">Profile</a></li>
                    <li><a href="contacts.html">Contacts</a></li>
                    <li><a href="mailbox.html">Mailbox</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ route('auth.getLogout') }}">Logout</a></li>
                </ul>
            </div>
            <div class="logo-element">
                IN+
            </div>
        </li>

        <li>
            <a href="{{ route('dashboard') }}"><i class="fa fa-th-large"></i> <span
                    class="nav-label">Dashboard</span></a>
        </li>
        <!-- <li>
            <a href="{{ route('tacgia.getTacGia') }}"><i class="fa fa-laptop"></i> <span class="nav-label">Grid
                    options</span></a>
        </li> -->
        <li>
            <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Quản Lý Thư Viện</span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="{{ route('khosach.getKhoSach')}}">Kho Sách</a></li>
                <li><a href="{{ route('tacgia.getTacGia') }}">Tác Giả</a></li>
                <li><a href="{{ route('theloai.getTheLoai') }}">Thể Loại</a></li>
                <li><a href="{{ route('nhaxuatban.getNhaXuatBan') }}">Nhà Xuất Bản</a></li>
            </ul>
        </li>

        <li class="{{ \App\Helpers\Helper::isActiveGroup([
        'quanlymuonsach.getQuanLyMuonSach',
        'quanlymuonsach.postAddMuonSach',
        'quanlymuonsach.getEditMuonSach',
        'quanlymuonsach.postEditMuonSach',
        'quanlymuonsach.postDeleteMuonSach'
    ]) }}">
            <a href="#"><i class="fa fa-bars"></i> <span class="nav-label">Quản Lý Mượn Sách</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li class="{{ \App\Helpers\Helper::isActiveRoute('quanlymuonsach.getQuanLyMuonSach') }}">
                    <a href="{{ route('quanlymuonsach.getQuanLyMuonSach') }}">Tất Cả</a>
                </li>
                <li>
                    <a href="#">Trạng Thái Mượn Sách<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li>
                            <a href="">Đang Mượn</a>
                        </li>
                        <li>
                            <a href="#">Đã Trả</a>
                        </li>
                        <li>
                            <a href="#">Quá Hạn Trả</a>
                        </li>
                        <li>
                            <a href="#">Đang Xử Lý</a>
                        </li>
                        <li>
                            <a href="#">Đã Hủy</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>


        <li>
            <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Cài Đặt </span><span
                    class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li>
                    <a href="#">Quản Lý Hệ Thống<span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        <li>
                            <a href="">Quản Lý </a>
                        </li>
                        <li>
                            <a href="#">Third Level Item</a>
                        </li>
                        <li>
                            <a href="#">Third Level Item</a>
                        </li>

                    </ul>
                </li>
                <li><a href="#">Second Level Item</a></li>
                <li>
                    <a href="#">Second Level Item</a>
                </li>
                <li>
                    <a href="#">Second Level Item</a>
                </li>
            </ul>
        </li>

    </ul>
</div>