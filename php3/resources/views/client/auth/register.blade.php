@extends('layouts.client')
@section('content')

    <div class="register-container container">
        <!-- Left Section -->
        <div class="register-left">
            <h2 class="register-title">Create an account</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        required>
                </div>
                <div class="form-check mb-3 d-flex align-items-center">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label terms" for="terms">
                        I agree to all the <a href="#" class="text-primary">Terms & Conditions</a>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign up</button>
            </form>
            <div class="social-buttons">
                <a href="#" class="google-btn">Google</a>
                <a href="#" class="facebook-btn">Facebook</a>
            </div>
            <div class="mt-3 text-center">
                Already have an account? <a href="{{ route('login.form') }}" class="text-primary">Log in</a>
            </div>
        </div>

        <!-- Right Section -->
        <div class="register-right">
        </div>
    </div>
@endsection