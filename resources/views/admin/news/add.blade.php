@extends('layouts.server')

@section('content')

    <div class="container mt-4">
        <h2>{{ $title }}</h2>
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    placeholder="Nhập tiêu đề" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Category --}}
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id"
                    required>
                    <option value="" disabled selected>Chọn danh mục con</option>
                    @if (isset($menuCategories))
                        @foreach ($menuCategories as $parentCategory)
                            <option value="" disabled style="font-weight: bold;">-- {{ $parentCategory->name }} --</option>
                            @if ($parentCategory->children->isNotEmpty())
                                @foreach ($parentCategory->children as $childCategory)
                                    <option value="{{ $childCategory->id }}" {{ old('category_id') == $childCategory->id ? 'selected' : '' }}>
                                        &nbsp;&nbsp;&nbsp;{{ $childCategory->name }}
                                    </option>
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <option value="" disabled>Không có danh mục nào.</option>
                    @endif
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Summary --}}
            <div class="mb-3">
                <label for="summary" class="form-label">Tóm tắt</label>
                <textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="3"
                    placeholder="Nhập tóm tắt ngắn gọn">{{ old('summary') }}</textarea>
                @error('summary')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Content with ID for Rich Text Editor --}}
            <div class="mb-3">
                <label for="content_editor" class="form-label">Nội dung</label>
                {{-- Removed 'required' attribute as CKEditor hides the original textarea --}}
                <textarea class="form-control @error('content') is-invalid @enderror" id="content_editor" name="content"
                    rows="10" placeholder="Nhập nội dung">{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Image --}}
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                    accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tags --}}
            <div class="mb-3">
                <label for="tags" class="form-label">Tags (cách nhau bởi dấu phẩy)</label>
                <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags"
                    placeholder="VD: thể thao, bóng đá,..." value="{{ old('tags') }}">
                @error('tags')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Boolean Flags --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured"
                            value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Nổi bật (Featured)</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_hot" name="is_hot" value="1" {{ old('is_hot') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_hot">Tin nóng (Hot)</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_trending" name="is_trending"
                            value="1" {{ old('is_trending') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_trending">Xu hướng (Trending)</label>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Xuất bản</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Thêm Tin Tức</button>
        </form>
    </div>

@endsection

{{-- Push CKEditor initialization script --}}
@push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#content_editor'), {
                // CKEditor configuration options
                // Configure the SimpleUploadAdapter:
                ckfinder: {
                    uploadUrl: '{{ route('admin.ckeditor.upload') . '?_token=' . csrf_token() }}' // Set the upload route
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush