@extends('layouts.guest')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            {{-- Image Column --}}
            <div class="col-6 login d-none d-md-block">
                <img src="{{ asset('site/images/venom-login.jpg') }}" alt="Confirm Password Image" class="img-fluid">
            </div>
            {{-- Form Column --}}
            <div class="col-md-6 col-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="text-center mb-3" style="font-weight: 600;">Xác nhận Mật khẩu</h1>
                        <div class="mb-4 text-sm text-muted text-center">
                            {{ __('Đây là khu vực an toàn của ứng dụng. Vui lòng xác nhận mật khẩu của bạn trước khi tiếp tục.') }}
                        </div>

                        {{-- Session Status (If needed, display standard Bootstrap alert) --}}
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label visually-hidden">{{ __('Mật khẩu') }}</label>
                                <input id="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    type="password" name="password" required autocomplete="current-password"
                                    placeholder="Mật khẩu" style="border-radius: 25px; background-color: #f8f9fa;" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg"
                                    style="background-color: #ff6f61; border-color: #ff6f61; border-radius: 25px; font-weight: 600;">
                                    {{ __('Xác nhận') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection