<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/login-admin.css') }}">
    {!! NoCaptcha::renderJs() !!}

</head>

<body style=" background-color: #223243">
    <div class="container signinForm">
        <form action="{{ route('auth.postLogin') }}" method="post">
            <div class="form signin">
                @csrf
                <h2>Đăng Nhập</h2>
                <div class="inputBox">
                    <input type="text" name="username" autofocus value="{{ old('username') }}" required="required">
                    <i class="fa-regular fa-user"></i>
                    <span>Tên đăng nhập...</span>
                </div>

                <div class="inputBox">
                    <input type="password" name="password" required="required">
                    <i class="fa-solid fa-lock"></i>
                    <span>Mật khẩu...</span>
                </div>

                <div class="inputBox">
                    {!! NoCaptcha::display() !!}
                </div>

                <div class="inputBox">
                    <a href="{{ route('password.request') }}"
                        style="color: #fff; font-size: 16px; text-decoration: none;">Quên
                        mật
                        khẩu.
                    </a>

                </div>

                @if(session()->has('success'))
                <div class="alert alert-success" style="color: #6bff33; font-size: 14px;">
                    {{ session('success') }}
                </div>
                @endif

                @if(session()->has('error'))
                <div class="alert alert-danger" style="color: red; font-size: 14px;">
                    {{ session('error') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger" style="color: red; font-size: 14px;">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class=" inputBox">
                    <input type="submit" value="Đăng Nhập">
                </div>
            </div>
        </form>
    </div>
    <!-- <script src="{{ asset('admin/assets/js/login-admin.js') }}"></script> -->
</body>

</html>