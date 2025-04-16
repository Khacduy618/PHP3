@extends('layouts.server')
@section('content')
    <div class="container mt-4">
        <div class="d-flex">
            <h2>{{ $title }}</h2>
            <button type="button" class="btn btn-secondary ms-auto" onclick="window.history.back();">Quay Lại</button>
        </div>
        <form action="{{ route('admin.news.update', ['slug' => $news->slug]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    placeholder="Nhập tiêu đề" value="{{ $news->title }}" >
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" >
                    <option value="" disabled>Chọn danh mục con</option> {{-- Changed placeholder --}}
                    {{-- Loop through hierarchical categories from MenuComposer --}}
                    @if (isset($menuCategories))
                        @foreach ($menuCategories as $parentCategory)
                            {{-- Display Parent Category as a disabled label --}}
                            <option value="" disabled style="font-weight: bold;">-- {{ $parentCategory->name }} --</option>
                            {{-- Loop through Children --}}
                            @if ($parentCategory->children->isNotEmpty())
                                @foreach ($parentCategory->children as $childCategory)
                                    {{-- Select the current news item's category --}}
                                    <option value="{{ $childCategory->id }}" {{ old('category_id', $news->category_id) == $childCategory->id ? 'selected' : '' }}>
                                        &nbsp;&nbsp;&nbsp;{{ $childCategory->name }} {{-- Indent child --}}
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
                    placeholder="Nhập tóm tắt ngắn gọn">{{ old('summary', $news->summary) }}</textarea>
                @error('summary')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Content with ID for Rich Text Editor --}}
            <div class="mb-3">
                <label for="content_editor" class="form-label">Nội dung</label>
                {{-- Removed '' attribute --}}
                <textarea class="form-control @error('content') is-invalid @enderror" id="content_editor" name="content" rows="10"
                    placeholder="Nhập nội dung">{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                    accept="image/*">
                {{-- Display current image if exists --}}
                @if ($news->image)
                    <img src="{{ Storage::url($news->image) }}" alt="Current Image" height="100" class="mt-2">
                @endif
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

             {{-- Tags --}}
            <div class="mb-3">
                <label for="tags" class="form-label">Thẻ (cách nhau bởi dấu phẩy)</label>
                {{-- Decode JSON tags string back to comma-separated for input value --}}
                @php
                    $tagsValue = '';
                    if (old('tags')) {
                        $tagsValue = old('tags');
                    } elseif ($news->tags) {
                        // Decode JSON string from DB, handle potential errors/null
                        $tagsArray = json_decode($news->tags, true);
                        if (is_array($tagsArray)) {
                            $tagsValue = implode(', ', $tagsArray);
                        }
                    }
                @endphp
                <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags"
                    placeholder="VD: thể thao, bóng đá,..." value="{{ $tagsValue }}">
                @error('tags')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Boolean Flags --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Nổi bật (Featured)</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_hot" name="is_hot" value="1" {{ old('is_hot', $news->is_hot) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_hot">Tin Hot</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_trending" name="is_trending" value="1" {{ old('is_trending', $news->is_trending) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_trending">Xu hướng (Trending)</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" >
                    <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>Nháp</option>
                    <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>Xuất bản</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật Tin Tức</button>
        </form>
    </div>
@endsection

{{-- Push CKEditor initialization script --}}
@push('scripts')
<script>
    ClassicEditor
        .create( document.querySelector( '#content_editor' ), {
            // CKEditor configuration options
            // Configure the SimpleUploadAdapter:
            ckfinder: {
                uploadUrl: '{{ route('admin.ckeditor.upload').'?_token='.csrf_token() }}' // Set the upload route
            }
        } )
        .catch( error => {
            console.error( error );
        } );
</script>
@endpush
