@extends('layouts.guest')

@section('content')
    <div class="container px-5 my-5">
        {{-- Match row structure from login.blade.php --}}
        <div class="row">
            <div class="col-6 p-0" style="width:fit-content">
                <img src="{{ asset('site/images/venom-login.jpg') }}" class="rounded-start shadow" alt="aaaa"
                    style="width:590px; height:703px">
            </div>
            {{-- Form Column (match login.blade.php) --}}
            <div class="col-6 p-0" style="height:fit-content;">
                <div class="card shadow-lg border-0 rounded-end">
                    <div class="card-body p-4 p-md-5"> {{-- Keep padding --}}
                        <h1 class="text-center mb-3" style="font-weight: 600;">Create an account</h1>
                        <div class="text-center text-muted mb-4">
                            <small> Already have an account? <a href="{{ route('login') }}">Log in</a></small>
                        </div>

                        {{-- Session Status (Optional) --}}
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->

                            <div class="form-group mb-3">
                                <input id="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    type="text" name="name" value="{{ old('name') }}" required placeholder="Nhập họ và tên"
                                    style="border-radius: 10px; background-color: #f8f9fa;" /> {{--
                                Rounded, light bg --}}
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <input id="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                    placeholder="Email" style="border-radius: 10px; background-color: #f8f9fa;" /> {{--
                                Rounded, light bg --}}
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
                                    type="password" name="password" required autocomplete="new-password"
                                    placeholder="Enter your password"
                                    style="border-radius: 10px; background-color: #f8f9fa;" /> {{-- Rounded, light bg --}}
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

                            <!-- Confirm Password -->
                            {{-- Add confirm password if your backend requires it --}}
                            <div class="form-group mb-3 position-relative">
                                <input id="password_confirmation" class="form-control form-control-lg" type="password"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirm Password"
                                    style="border-radius: 10px; background-color: #f8f9fa;" />
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="form-check mb-4">
                                <input id="terms" type="checkbox"
                                    class="form-check-input @error('terms') is-invalid @enderror" name="terms" required>
                                <label for="terms" class="form-check-label text-muted"><small>I agree to the <a
                                            href="#">Terms & Conditions</a></small></label>
                                @error('terms')
                                    <span class="invalid-feedback d-block" role="alert"> {{-- Ensure error shows --}}
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <!-- Submit Button -->
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary btn-lg w-100"
                                    style="background-color: #6f42c1; border-color: #6f42c1; border-radius: 10px; font-weight: 600;">
                                    {{-- Purple color like image, less rounded --}}
                                    {{ __('Create account') }}
                                </button>
                            </div>

                            <div class="text-center text-muted my-4"><small>Or register with</small></div>

                            <!-- Social Login Buttons -->
                            <div class="d-flex gap-3 mb-4">
                                <button type="button" class="btn btn-outline-secondary btn-lg w-100"
                                    style="border-radius: 10px;"> {{-- Less rounded --}}
                                    {{-- Replace text with actual icon if available --}}
                                    G Google
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-lg w-100"
                                    style="border-radius: 10px;"> {{-- Less rounded --}}
                                    {{-- Replace text with actual icon if available --}}
                                    A Apple
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection