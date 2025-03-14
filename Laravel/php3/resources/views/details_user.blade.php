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
            <h5 class="card-title">{{ $user->full_name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Giới tính:</strong> {{ ucfirst($user->gender) }}</p>
            <p class="card-text"><strong>Số điện thoại:</strong> {{ $user->phone_number }}</p>
            <p class="card-text"><strong>Địa chỉ:</strong> {{ $user->address }}</p>
            <p class="card-text"><strong>Trạng thái:</strong> {{ $user->status ? 'Hoạt động' : 'Không hoạt động' }}</p>
            <a href="{{ url('/users') }}" class="btn btn-primary">Quay lại</a>
        </div>
    </div>
</div>
</body>
</html>