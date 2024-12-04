<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>

<body>

    <div>
        <h1>Trang Chủ</h1>
        @if(auth()->user()->role == 1)
        <a href="http://127.0.0.1:8000/public/admin/dashboard">Vào Trang Admin</a>
        @else
        @endif

    </div>
</body>

</html>