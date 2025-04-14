@extends('layouts.server')

@section('content')
    <div class="container mt-4">
        <h2>{{ $title }}</h2>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Use PUT method for update --}}

            {{-- Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Tên người dùng</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    placeholder="Nhập tên người dùng" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    placeholder="Nhập email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password (Optional) --}}
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu mới (Để trống nếu không muốn thay đổi)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Nhập mật khẩu mới">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password (Optional) --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Nhập lại mật khẩu mới">
            </div>

            {{-- Role --}}
            <div class="mb-3">
                <label for="role" class="form-label">Vai trò</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Người dùng</option>
                    {{-- Prevent demoting the last admin if needed (add logic here or in controller) --}}
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Avatar --}}
            <div class="mb-3">
                <label for="avatar" class="form-label">Ảnh đại diện (Để trống nếu không muốn thay đổi)</label>
                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar"
                    accept="image/*">
                {{-- Display current avatar --}}
                @if ($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="Current Avatar" height="60" class="mt-2 rounded-circle"
                        onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/user/avatar-2.jpg') }}';">
                @endif
                @error('avatar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật Người dùng</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection