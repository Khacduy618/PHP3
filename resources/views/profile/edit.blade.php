@extends('layouts.server')

@section('content')
    {{-- Page Title (Example structure, adjust if your layout has a specific way) --}}
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang Chủ</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Tài Khoản</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ $page_title ?? 'Hồ Sơ' }}</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">{{ $page_title ?? 'Hồ Sơ Của Bạn' }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content using Bootstrap Grid --}}
    <div class="row">
        {{-- Profile Information Card --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Thông Tin Hồ Sơ</h5>
                </div>
                <div class="card-body">
                    {{-- Include the partial, assuming it uses standard form elements now --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Update Password Card --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Cập Nhật Mật Khẩu</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Delete Account Card (Full Width Below) --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Xóa Tài Khoản</h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection