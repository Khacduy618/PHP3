@extends('layouts.guest')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            {{-- Image Column --}}
            <div class="col-6 login d-none d-md-block">
                <img src="{{ asset('site/images/venom-login.jpg') }}" alt="Reset Password Image" class="img-fluid">
            </div>
            {{-- Form Column --}}
            <div class="col-md-6 col-12">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="text-center mb-4" style="font-weight: 600;">Đặt lại mật khẩu</h1>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label visually-hidden">{{ __('Email') }}</label>
                                <input id="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                                    autocomplete="username" placeholder="Email"
                                    style="border-radius: 25px; background-color: #f8f9fa;" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label visually-hidden">{{ __('Mật khẩu') }}</label>
                                <input id="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    type="password" name="password" required autocomplete="new-password"
                                    placeholder="Mật khẩu mới" style="border-radius: 25px; background-color: #f8f9fa;" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group mb-3">
                                <label for="password_confirmation"
                                    class="form-label visually-hidden">{{ __('Xác nhận mật khẩu') }}</label>
                                <input id="password_confirmation" class="form-control form-control-lg" type="password"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Xác nhận mật khẩu mới"
                                    style="border-radius: 25px; background-color: #f8f9fa;" />
                                {{-- Error display for password_confirmation is usually handled by the 'password' field's
                                confirmed rule --}}
                            </div>

                            <div class="form-group d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg"
                                    style="background-color: #ff6f61; border-color: #ff6f61; border-radius: 25px; font-weight: 600;">
                                    {{ __('Đặt lại mật khẩu') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection