@extends('layouts.server')

@section('content')

    <div class="container mt-4">
        <div class="d-flex">
            <h2>{{ $title }}</h2>
            <button type="button" class="btn btn-secondary ms-auto" onclick="window.history.back();">Quay Lại</button>
        </div>
        <form action="{{ route('admin.category.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    placeholder="Nhập tên danh mục" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    placeholder="Nhập slug" value="{{ old('slug') }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="4" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Danh mục cha (Để trống nếu là danh mục gốc)</label>
                <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                    <option value="">-- Không có --</option> {{-- Option for creating a parent category --}}
                    {{-- Loop through parent categories from MenuComposer --}}
                    @if (isset($menuCategories))
                        @foreach ($menuCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" {{ old('parent_id') == $parentCategory->id ? 'selected' : '' }}>
                                {{ $parentCategory->name }}
                            </option>
                            {{-- We typically don't allow selecting children as parents here --}}
                        @endforeach
                    @else
                        <option value="" disabled>Không có danh mục cha nào.</option>
                    @endif
                </select>
                @error('parent_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status"
                            id="status_visible" value="Hiện" {{ old('status') == 'Hiện' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_visible">Hiển thị</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status"
                            id="status_hidden" value="Ẩn" {{ old('status') == 'Ẩn' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_hidden">Ẩn</label>
                    </div>
                </div>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Thêm Danh Mục</button>
        </form>
    </div>

@endsection