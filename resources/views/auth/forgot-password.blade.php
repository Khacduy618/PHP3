@extends('layouts.guest')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            {{-- Image Column --}}
            <div class="col-6 p-0" style="width:fit-content"> {{-- Hide on small screens --}}
                <img src="{{ asset('site/images/venom-login.jpg') }}" alt="Forgot Password Image"
                    class="rounded-start shadow" style="width:500px; height:400px">
            </div>
            {{-- Form Column --}}
            <div class=" col-6 p-0" style="height:fit-content;">
                <div class="card shadow-lg border-0 rounded-end">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="text-center mb-3" style="font-weight: 600;">Quên mật khẩu?</h1>
                        <div class="mb-4 text-sm text-muted text-center">
                            {{ __('Không sao. Chỉ cần cho chúng tôi biết địa chỉ email của bạn và chúng tôi sẽ gửi cho bạn một liên kết đặt lại mật khẩu qua email.') }}
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label visually-hidden">{{ __('Email') }}</label> {{-- Hide
                                label visually but keep for accessibility --}}
                                <input id="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    type="text" name="email" value="{{ old('email') }}" autofocus placeholder="Email"
                                    style="border-radius: 25px; background-color: #f8f9fa;" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group d-grid mt-4"> {{-- Use d-grid for full width button --}}
                                <button type="submit" class="btn btn-primary btn-lg"
                                    style="background-color: #ff6f61; border-color: #ff6f61; border-radius: 25px; font-weight: 600;">
                                    {{ __('Gửi liên kết đặt lại mật khẩu') }}
                                </button>
                            </div>
                        </form>
                        <div class="text-center text-muted mt-4">
                            <small> Nhớ mật khẩu? <a href="{{ route('login') }}">Đăng nhập</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection