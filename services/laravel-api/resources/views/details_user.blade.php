<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>User</title>
</head>
<body>
<div class="container">
    <h2>Thông tin người dùng</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Giới tính:</strong> {{ $user->gender }}</p>
            <p class="card-text"><strong>Số điện thoại:</strong> {{ $user->phone }}</p>
            <p class="card-text"><strong>Địa chỉ:</strong> {{ $user->address }}</p>
            <div class="d-flex"><a href="/users/edit/{{ $user->email }}"  class="btn btn-primary">Sửa</a>
            <form action="/users/delete/{{ $user->email }}"  method="POST" onsubmit="return confirm('Xác nhận xoá người dùng này?')">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">Xoá</button>
            </form>
            <a href="/" class="btn btn-primary">Quay lại</a></div>
        </div>
    </div>
</div>
</body>
</html>