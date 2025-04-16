@extends('layouts.server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $title }}</h2>
        
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">Thêm tin tức</a>
    </div>
    <div class="card">
        <div class="card-header">
            <form action="{{ route('admin.news.list') }}" method="GET">
                <div class="row g-3 align-items-center">
                    {{-- Search Input --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="search" class="icon-search"></i></span>
                            <input type="search" name="search" class="form-control" placeholder="Tìm kiếm tiêu đề, tóm tắt..."
                                value="{{ request('search') }}">
                        </div>
                    </div>
                    {{-- Category Filter --}}
                    <div class="col-md-4 col-lg-3">
                        <select name="category_id" class="form-select">
                            <option value="">-- Lọc theo danh mục --</option>
                            @foreach($categoriesForFilter as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                {{-- Include children if needed, adjust indentation --}}
                                @if($category->children->isNotEmpty())
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->id }}" {{ request('category_id') == $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;&nbsp;{{ $child->name }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                    </div>
                    {{-- Submit Button --}}
                    <div class="col-md-2 col-lg-2">
                        <button type="submit" class="btn btn-primary w-100">Lọc</button>
                    </div>
                    {{-- Hidden inputs for sorting --}}
                    @if(request('sort_by'))
                        <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                    @endif
                    @if(request('sort_dir'))
                        <input type="hidden" name="sort_dir" value="{{ request('sort_dir') }}">
                    @endif
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>
                            @php $sortIcon = $sortBy == 'id' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') : 'ti-arrows-sort'; @endphp
                            <a
                                href="{{ route('admin.news.list', ['sort_by' => 'id', 'sort_dir' => $sortBy == 'id' && $sortDir == 'asc' ? 'desc' : 'asc']) }}">
                                ID <i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th>Ảnh</th>
                        <th>
                            @php $sortIcon = $sortBy == 'title' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') : 'ti-arrows-sort'; @endphp
                            <a
                                href="{{ route('admin.news.list', ['sort_by' => 'title', 'sort_dir' => $sortBy == 'title' && $sortDir == 'asc' ? 'desc' : 'asc']) }}">
                                Tiêu đề <i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th>
                            @php $sortIcon = $sortBy == 'created_at' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') : 'ti-arrows-sort'; @endphp
                            <a
                                href="{{ route('admin.news.list', ['sort_by' => 'created_at', 'sort_dir' => $sortBy == 'created_at' && $sortDir == 'asc' ? 'desc' : 'asc']) }}">
                                Ngày tạo <i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th>Danh mục</th>
                        <th>Người tạo</th>
                        <th>Trạng thái</th>
                        <th>Trạng thái Xóa</th> {{-- Add Deleted Status Column --}}
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Adjust loop iteration for pagination --}}
                    @foreach($news as $index => $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <div class="imgtb" style="width:200px;"><img
                                        src="{{$item->image ? Storage::url($item->image) : asset('site/images/39-324x235.jpg') }}"
                                        alt="{{ $item->title }}"
                                        onerror="this.onerror=null;this.src='{{ asset('site/images/39-324x235.jpg') }}';"
                                        style="max-width:100%;object-fit:cover;" class="mt-2"></div>
                            </td>
                            <td>{{ $item->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}</td> {{-- Show time too --}}
                            {{-- Access category name via relationship --}}
                            <td>{{ $item->category->name ?? 'N/A' }}</td>
                            {{-- Access user name via relationship --}}
                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                            <td>
                                @if($item->status === 'published')
                                    <span class="badge bg-success">Xuất bản</span>
                                @elseif($item->status === 'draft')
                                    <span class="badge bg-warning text-dark">Nháp</span>
                                @else
                                    <span class="badge bg-danger text-dark">Lưu trữ</span>
                                @endif
                            </td>
                            <td> {{-- Deleted Status Column --}}
                                @if($item->deleted_at)
                                    <span class="badge bg-danger">Đã xóa</span>
                                @else
                                    <span class="badge bg-success">Hoạt động</span>
                                @endif
                            </td>
                            <td class="text-center"> {{-- Center buttons --}}
                                <div class="d-flex">
                                    @if($item->deleted_at)
                                        {{-- Restore Button --}}
                                        <form action="{{ route('admin.news.update', ['slug' => $item->slug]) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="restore" value="1">
                                            <button type="submit" class="btn btn-sm btn-warning me-2" title="Khôi phục">
                                                <i class="fas fa-undo"></i> Khôi phục
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-primary me-2" disabled>
                                            <i class="fas fa-edit"></i> Sửa
                                        </button>
                                        {{-- Optional: Force Delete --}}
                                        {{-- <form action="{{ route('admin.news.destroy', ['slug' => $item->slug]) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Xóa vĩnh viễn?');">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="force_delete" value="1">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa vĩnh viễn"><i
                                                    class="fas fa-times"></i></button>
                                        </form> --}}
                                    @else
                                        {{-- Edit Button --}}
                                        <a href="{{ route('admin.news.edit', ['slug' => $item->slug]) }}"
                                            class="btn btn-sm btn-primary me-2">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        {{-- Soft Delete Button --}}
                                        <form action="{{ route('admin.news.destroy', ['slug' => $item->slug]) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa tin này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Re-add pagination links --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $news->links() }}
            </div>
        </div>
    </div>
@endsection
