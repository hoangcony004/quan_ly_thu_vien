<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{$title}}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        .form-group {
            position: relative;
        }

        .form-group i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
        }

        .form-group input:focus+i {
            color: #000;
        }
    </style>
</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold text-center">Đổi Mật Khẩu</h2>

                    <p>
                        Vui lòng nhập lại địa chỉ email để xác minh đó là bạn và nhập mật khẩu mới.
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" action="{{ route('password.update') }}" method="POST"
                                id="resetPasswordForm">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Nhập email..." autofocus>
                                    <span class="text-danger" id="emailError"></span>
                                </div>

                                <div class="form-group" style="position: relative;">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Nhập mật khẩu...">
                                    <i class="fa fa-eye" id="togglePassword"
                                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                                    <span class="text-danger" id="passwordError"></span>
                                </div>

                                <div class="form-group" style="position: relative;">
                                    <input type="password" class="form-control" id="passwordConfirmation"
                                        name="password_confirmation" placeholder="Nhập lại mật khẩu...">
                                    <i class="fa fa-eye" id="togglePasswordConfirmation"
                                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                                    <span class="text-danger" id="passwordConfirmationError"></span>
                                </div>
                                <button type="submit" class="btn btn-primary block full-width m-b">Đổi Mật Khẩu</button>
                            </form>
                        </div>

                        <script>
                            document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
                                let isValid = true;

                                // Lấy các giá trị từ form
                                const email = document.getElementById('email').value.trim();
                                const password = document.getElementById('password').value.trim();
                                const passwordConfirmation = document.getElementById('passwordConfirmation').value
                                    .trim();

                                // Xóa lỗi cũ
                                document.getElementById('emailError').textContent = '';
                                document.getElementById('passwordError').textContent = '';
                                document.getElementById('passwordConfirmationError').textContent = '';

                                // Kiểm tra email
                                if (email === '') {
                                    document.getElementById('emailError').textContent =
                                        'Email không được để trống.';
                                    isValid = false;
                                } else if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
                                    document.getElementById('emailError').textContent = 'Email không hợp lệ.';
                                    isValid = false;
                                }

                                // Kiểm tra mật khẩu
                                if (password === '') {
                                    document.getElementById('passwordError').textContent =
                                        'Mật khẩu không được để trống.';
                                    isValid = false;
                                } else if (password.length < 6) {
                                    document.getElementById('passwordError').textContent =
                                        'Mật khẩu phải có ít nhất 6 ký tự.';
                                    isValid = false;
                                }

                                // Kiểm tra mật khẩu xác nhận
                                if (passwordConfirmation === '') {
                                    document.getElementById('passwordConfirmationError').textContent =
                                        'Vui lòng nhập lại mật khẩu.';
                                    isValid = false;
                                } else if (password !== passwordConfirmation) {
                                    document.getElementById('passwordConfirmationError').textContent =
                                        'Mật khẩu nhập lại không khớp.';
                                    isValid = false;
                                }

                                // Nếu có lỗi, ngăn form submit
                                if (!isValid) {
                                    event.preventDefault();
                                }
                            });
                        </script>
                        <script>
                            // Toggle mật khẩu chính
                            const togglePassword = document.getElementById('togglePassword');
                            const passwordField = document.getElementById('password');

                            togglePassword.addEventListener('click', function() {
                                const type = passwordField.getAttribute('type') === 'password' ? 'text' :
                                    'password';
                                passwordField.setAttribute('type', type);
                                this.classList.toggle('fa-eye-slash'); // Thay đổi icon
                            });

                            // Toggle mật khẩu xác nhận
                            const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
                            const passwordConfirmationField = document.getElementById('passwordConfirmation');

                            togglePasswordConfirmation.addEventListener('click', function() {
                                const type = passwordConfirmationField.getAttribute('type') === 'password' ?
                                    'text' : 'password';
                                passwordConfirmationField.setAttribute('type', type);
                                this.classList.toggle('fa-eye-slash'); // Thay đổi icon
                            });
                        </script>


                    </div>
                    @if(session('success'))
                    <div class="text-color-green">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <hr />
    </div>

</body>

</html>