@extends('layouts.server')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $title }}</h2>
        <div>
            <button id="show-api-data" class="btn btn-info me-2">Show API Data</button>
            <a href="{{ route('admin.category.create') }}" class="btn btn-success">Thêm loại tin</a>
        </div>
    </div>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="dropdown pc-h-item d-inline-flex d-md-none">
                <a class="pc-head-link dropdown-toggle arrow-none mt-2 ms-2" style="color:black;width:fit-content;"
                    data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-search" style="font-size:20px;"></i>
                </a>
                <div class="dropdown-menu pc-h-dropdown drp-search">
                    {{-- Functional Search Form for Small Screens --}}
                    <form action="{{ route('admin.category.list') }}" method="GET" class="px-3">
                        <div class="form-group mb-0 d-flex align-items-center">
                            <i data-feather="search" class="icon-search"></i>
                            <input type="search" name="search" class="form-control border-0 shadow-none"
                                placeholder="Tìm kiếm tên, mô tả..." value="{{ request('search') }}">
                            {{-- Preserve sorting parameters --}}
                            @if(request('sort_by'))
                                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                            @endif
                            @if(request('sort_dir'))
                                <input type="hidden" name="sort_dir" value="{{ request('sort_dir') }}">
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            {{-- Functional Search Form for Desktop --}}
            <div class="pc-h-item d-none d-md-inline-flex ms-auto p-2">
                <form action="{{ route('admin.category.list') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text"><i data-feather="search" class="icon-search"></i></span>
                        <input type="search" name="search" class="form-control" placeholder="Tìm kiếm..."
                            value="{{ request('search') }}">
                        <select name="status" class="form-select">
                            <option value="">Tất cả trạng thái</option>
                            <option value="Hiện" {{ request('status') == 'Hiện' ? 'selected' : '' }}>Hiện</option>
                            <option value="Ẩn" {{ request('status') == 'Ẩn' ? 'selected' : '' }}>Ẩn</option>
                        </select>
                        <select name="deleted" class="form-select">
                            <option value="">Tất cả trạng thái xóa</option>
                            <option value="false" {{ request('deleted') == 'false' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="true" {{ request('deleted') == 'true' ? 'selected' : '' }}>Đã xóa</option>
                        </select>
                        <!-- <select name="sort_by" class="form-select">
                                        <option value="">Sắp xếp theo</option>
                                        <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Mã danh mục</option>
                                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Tên danh mục
                                        </option>
                                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Ngày
                                            tạo</option>
                                    </select>
                                    <select name="sort_dir" class="form-select">
                                        <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                                        <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                                    </select> -->
                        <button type="submit" class="btn btn-success">Lọc</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>
                            @php
                                $sortIcon = $sortBy == 'id' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') :
                                    'ti-arrows-sort';
                                $url = route('admin.category.list', array_merge(request()->query(), [
                                    'sort_by' => 'id',
                                    'sort_dir' => $sortBy == 'id' && $sortDir == 'asc' ? 'desc' : 'asc'
                                ]));
                            @endphp
                            <a href="{{ $url }}">
                                Mã danh mục<i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th>
                            @php
                                $sortIcon = $sortBy == 'name' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') :
                                    'ti-arrows-sort';
                                $url = route('admin.category.list', array_merge(request()->query(), [
                                    'sort_by' => 'name',
                                    'sort_dir' => $sortBy == 'name' && $sortDir == 'asc' ? 'desc' : 'asc'
                                ]));
                            @endphp
                            <a href="{{$url}}">
                                Tên danh mục <i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th> {{-- Regular Status --}}
                        <th>Trạng thái Xóa</th> {{-- Deleted Status --}}
                        <th>
                            @php
                                $sortIcon = $sortBy == 'created_at' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') :
                                    'ti-arrows-sort';
                                $url = route('admin.category.list', array_merge(request()->query(), [
                                    'sort_by' =>
                                        'created_at',
                                    'sort_dir' => $sortBy == 'created_at' && $sortDir == 'asc' ? 'desc' :
                                        'asc'
                                ]));
                            @endphp
                            <a href="{{$url}}">
                                Ngày tạo <i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Adjust loop iteration for pagination --}}
                    @foreach($categories as $index => $category)
                        <tr>
                            <td class="text-center">{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td> {{-- Regular Status Column --}}
                                @if($category->status === 'Ẩn')
                                    <span class="badge bg-danger">Ẩn</span>
                                @else
                                    <span class="badge bg-success">Hiện</span>
                                @endif
                            </td>
                            <td> {{-- Deleted Status Column --}}
                                @if($category->deleted_at)
                                    <span class="badge bg-danger">Đã xóa</span>
                                @else
                                    <span class="badge bg-success">Hoạt động</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y') }}</td>
                            <td class="text-center d-flex justify-content-center"> {{-- Center buttons --}}
                                @if($category->deleted_at)
                                    {{-- Restore Button --}}
                                    <form action="{{ route('admin.category.update', ['slug' => $category->slug]) }}" method="POST"
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
                                    {{-- Optional: Force Delete Button --}}
                                    {{-- <form action="{{ route('admin.category.destroy', ['slug' => $category->slug]) }}"
                                        method="POST" class="d-inline" onsubmit="return confirm('Xóa vĩnh viễn?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="force_delete" value="1">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa vĩnh viễn"><i
                                                class="fas fa-times"></i></button>
                                    </form> --}}
                                @else
                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.category.edit', ['slug' => $category->slug]) }}"
                                        class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    {{-- Hide/Show Buttons --}}
                                    @if($category->status === 'Ẩn')
                                        <form action="{{ route('admin.category.show', ['slug' => $category->slug]) }}" method="POST"
                                            class="d-inline me-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Hiện">
                                            <button type="submit" class="btn btn-sm btn-success" title="Hiện">
                                                <i class="fas fa-eye"></i> Hiện
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.category.hide', ['slug' => $category->slug]) }}" method="POST"
                                            class="d-inline me-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Ẩn">
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Ẩn">
                                                <i class="fas fa-eye-slash"></i> Ẩn
                                            </button>
                                        </form>
                                    @endif
                                    {{-- Soft Delete Button --}}
                                    <form action="{{ route('admin.category.destroy', ['slug' => $category->slug]) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Re-add pagination links --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links() }}
            </div>
        </div>

        {{-- Area to display JSON data --}}
        <div class="mt-4">
            <h3>API Data Output:</h3>
            <pre id="json-output" class="bg-light p-3 border rounded"
                style="max-height: 400px; overflow-y: auto; display: none;"></pre>
        </div>
@endsection

    @push('scripts') {{-- Use a stack for scripts if your layout supports it, otherwise place script tag directly --}}
        <script>
            document.getElementById('show-api-data').addEventListener('click', function () {
                const outputArea = document.getElementById('json-output');
                outputArea.textContent = 'Loading...'; // Show loading indicator
                outputArea.style.display = 'block'; // Make area visible

                fetch('{{ route('api.categories.index') }}') // Use Laravel route helper
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Format JSON nicely with 2-space indentation
                        outputArea.textContent = JSON.stringify(data, null, 2);
                    })
                    .catch(error => {
                        console.error('Error fetching API data:', error);
                        outputArea.textContent = `Error loading data: ${error.message}`;
                    });
            });
        </script>
    @endpush