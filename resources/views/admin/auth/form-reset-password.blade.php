<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{$title}}</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold text-center">Quên Mật Khẩu</h2>

                    <p>
                        Vui lòng nhập địa chỉ email để chúng tôi khôi phục mật khẩu cho bạn.
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" name="email" placeholder="Nhập email..."
                                        autofocus required>
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Gửi Yêu Cầu</button>
                                <a href="javascript:history.back()" class="btn btn-default block full-width m-b">Quay
                                    lại</a>
                            </form>
                        </div>
                    </div>
                    @if(session('success'))
                    <div
                        style="color: green; font-weight: bold; margin: 10px 0; padding: 10px; border: 1px solid green; border-radius: 5px; background-color: #e6ffe6;">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div
                        style="color: red; margin: 10px 0; padding: 10px; border: 1px solid red; border-radius: 5px; background-color: #ffe6e6;">
                        <ul style="margin: 0; padding: 0; list-style: none;">
                            @foreach ($errors->all() as $error)
                            <li style="margin-bottom: 5px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        <hr />
        <!-- <div class="row">
            <div class="col-md-6">
                Copyright Example Company
            </div>
            <div class="col-md-6 text-right">
                <small>© 2014-2015</small>
            </div>
        </div> -->
    </div>

</body>

</html>