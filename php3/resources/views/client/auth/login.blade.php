@extends('layouts.client')
@section('content')

    <div class="container mt-4 mb-4">
        <h2 class="login-title text-center">Đăng nhập</h2>
        <div class="row">
            <div class="col-6 ">
                <form action="{{ route('login') }}" method="POST" class="w-100">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Nhập mật khẩu" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
                <div class="mt-3 text-center">
                    Chưa có tài khoản?<a href="{{ route('register.form') }}" class="text-primary"> Đăng ký
                        ngay </a>
                </div>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-center">
                <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo/logo.png') }}" alt=""></a>
            </div>
        </div>

    </div>
@endsection