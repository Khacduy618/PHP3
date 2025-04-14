@extends('layouts.guest')

@section('content')
    <div class="container px-5 my-5"> {{-- Added margin top/bottom --}}
        <div class="row">
            <div class="col-6 p-0" style="width:fit-content">
                <img src="{{ asset('site/images/venom-login.jpg') }}" class="rounded-start shadow" alt="aaaa"
                    style="width:550px; height:560px">
            </div>
            <div class="col-6 p-0" style="height:fit-content;"> {{-- Adjusted column width --}}
                <div class="card shadow-lg border-0 rounded-end"> {{-- Added shadow, removed border, rounded --}}
                    <div class="card-body p-4 p-md-5"> {{-- Increased padding --}}
                        <h1 class="text-center mb-4" style="font-weight: 600;">Đăng nhập</h1>

                        {{-- Session Status (Optional) --}}
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <input id="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    type="email" name="email" value="{{ old('email') }}" required autofocus
                                    autocomplete="username" placeholder="Email"
                                    style="border-radius: 25px; background-color: #f8f9fa;" /> {{-- Rounded, light bg --}}
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3 position-relative"> {{-- Added position-relative --}}
                                <input id="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    type="password" name="password" required autocomplete="current-password"
                                    placeholder="Mật khẩu" style="border-radius: 25px; background-color: #f8f9fa;" /> {{--
                                Rounded, light bg --}}
                                {{-- Simple text toggle, replace with icon if FontAwesome is available --}}
                                {{-- <span class="password-toggle"
                                    style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6c757d;">👁️</span>
                                --}}
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                    <label for="remember_me"
                                        class="form-check-label text-muted"><small>{{ __('Ghi nhớ tôi') }}</small></label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="text-muted" style="font-size: 0.9em;" href="{{ route('password.request') }}">
                                        <small>{{ __('Quên mật khẩu?') }}</small>
                                    </a>
                                @endif
                            </div>


                            <!-- Submit Button -->
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary btn-lg w-100"
                                    style="background-color: #ff6f61; border-color: #ff6f61; border-radius: 25px; font-weight: 600;">
                                    {{-- Orange color, rounded, bold --}}
                                    {{ __('Đăng nhập') }}
                                </button>
                            </div>

                            <div class="text-center text-muted my-4"><small>Hoặc đăng nhập với</small></div>

                            <!-- Social Login Buttons -->
                            <div class="d-flex gap-3 mb-4">
                                <button type="button" class="btn btn-outline-secondary btn-lg w-100"
                                    style="border-radius: 25px;"> {{-- Rounded --}}
                                    {{-- Replace text with actual icon if available --}}
                                    G Google
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-lg w-100"
                                    style="border-radius: 25px;"> {{-- Rounded --}}
                                    {{-- Replace text with actual icon if available --}}
                                    A Apple
                                </button>
                            </div>

                        </form>

                        <div class="text-center text-muted mt-4">
                            <small> Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection