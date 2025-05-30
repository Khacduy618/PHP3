<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Danh sách Users</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã người dùng</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Giới tính</th>
                    <th>Ảnh đại diện</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->user_code }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->gender }}</td>
                    <td>
                        @if($user->image)
                            <img src="{{ asset($user->image) }}" alt="Avatar" width="50">
                        @else
                            <span>Chưa có ảnh</span>
                        @endif
                    </td>
                    <td>{{ $user->status ? 'Hoạt động' : 'Không hoạt động' }}</td>
                    <td><a href="/details_user/{{ $user->user_code }}" class="btn btn-success">More infomation</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
