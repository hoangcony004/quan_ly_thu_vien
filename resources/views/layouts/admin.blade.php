<!DOCTYPE html>
<html>

<head>
    @include('admin.components.head')
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            @include('admin.components.navbar')
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                @include('admin.components.header')
            </div>

            <div class="wrapper wrapper-content">
                @yield('content')
            </div>

            <div class="footer">
                @include('admin.components.footer')
            </div>
        </div>
    </div>

    <div id="right-sidebar">
        @include('admin.components.right-sidebar')
    </div>

    <!-- scripts -->
    @include('admin.components.script')
</body>

</html>