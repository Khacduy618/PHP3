{{-- Using standard HTML and Bootstrap classes --}}
<section>
    <header>
        {{-- Removed default header text, assuming parent view provides it --}}
        {{-- <h2 class="text-lg font-medium text-gray-900">...</h2> --}}
        <p class="mt-1 text-sm text-muted"> {{-- Use text-muted --}}
            {{ __("Cập nhật thông tin hồ sơ và địa chỉ email của tài khoản của bạn.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4" enctype="multipart/form-data"> {{-- Removed
        space-y-6, use mb-3 on elements --}}
        @csrf
        @method('patch')

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Avatar --}}
        <div class="mb-3">
            <label for="avatar" class="form-label">{{ __('Avatar') }}</label>
            {{-- Display current avatar --}}
            <div class="mb-2">
                @if ($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="Current Avatar" class="rounded-circle" width="80"
                        height="80" style="object-fit: cover;">
                @else
                    <img src="{{ asset('site/images/person_1.jpg') }}" alt="Default Avatar" class="rounded-circle"
                        width="80" height="80">
                @endif
            </div>
            <input id="avatar" name="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror"
                accept="image/*" />
            @error('avatar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">
                {{ __('Tải lên ảnh đại diện mới. Để trống để giữ ảnh hiện tại.') }}
            </div>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-muted">
                        {{ __('Địa chỉ email của bạn chưa được xác minh.') }}

                        <button form="send-verification"
                            class="btn btn-link p-0 text-decoration-underline text-sm text-muted">
                            {{ __('Nhấn vào đây để gửi lại email xác minh.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-success">
                            {{ __('Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Save Button and Status --}}
        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-muted">{{ __('Đã lưu.') }}</p>
            @endif
        </div>
    </form>
</section>