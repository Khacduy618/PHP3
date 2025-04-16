@extends('layouts.server')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $title }}</h2>
        <div class=" d-flex align-items-center ms-auto"> {{-- Added card-title and padding --}}
            {{-- Mobile Search Dropdown --}}
            <div class="dropdown pc-h-item d-inline-flex d-md-none">
                <a class="pc-head-link dropdown-toggle arrow-none me-2" style="color:black;width:fit-content;"
                    data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-search" style="font-size:20px;"></i>
                </a>
                <div class="dropdown-menu pc-h-dropdown drp-search">
                    <form action="{{ route('admin.users.index') }}" method="GET" class="px-3 py-2">
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="search" class="icon-search"></i></span>
                            <input type="search" name="search" class="form-control" placeholder="Tìm kiếm..."
                                value="{{ request('search') }}">
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
            {{-- Desktop Search Input Group --}}
            <div class="pc-h-item d-none d-md-inline-flex ms-auto p-2">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text"><i data-feather="search" class="icon-search"></i></span>
                        <input type="search" name="search" class="form-control" placeholder="Tìm kiếm tên, email..."
                            value="{{ request('search') }}">
                        @if(request('sort_by'))
                            <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                        @endif
                        @if(request('sort_dir'))
                            <input type="hidden" name="sort_dir" value="{{ request('sort_dir') }}">
                        @endif
                        {{-- Optional: Add a submit button if Enter key isn't sufficient --}}
                        {{-- <button type="submit" class="btn btn-primary ms-2">Tìm</button> --}}
                    </div>
                </form>
            </div>
        </div>
        {{-- Keep the Add User button separate for now, or integrate into card-title if preferred --}}
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">Thêm Người dùng</a>
    </div>

    <div class="card">

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>
                            @php $sortIcon = $sortBy == 'id' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') : 'ti-arrows-sort'; @endphp
                            <a
                                href="{{ route('admin.users.index', ['sort_by' => 'id', 'sort_dir' => $sortBy == 'id' && $sortDir == 'asc' ? 'desc' : 'asc']) }}">
                                Mã người dùng <i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th>Ảnh đại diện</th>
                        <th>
                            @php $sortIcon = $sortBy == 'name' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') : 'ti-arrows-sort'; @endphp
                            <a
                                href="{{ route('admin.users.index', ['sort_by' => 'name', 'sort_dir' => $sortBy == 'name' && $sortDir == 'asc' ? 'desc' : 'asc']) }}">
                                Tên <i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th>
                            @php $sortIcon = $sortBy == 'email' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') : 'ti-arrows-sort'; @endphp
                            <a
                                href="{{ route('admin.users.index', ['sort_by' => 'email', 'sort_dir' => $sortBy == 'email' && $sortDir == 'asc' ? 'desc' : 'asc']) }}">
                                Email <i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th>
                            @php $sortIcon = $sortBy == 'role' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') : 'ti-arrows-sort'; @endphp
                            <a
                                href="{{ route('admin.users.index', ['sort_by' => 'role', 'sort_dir' => $sortBy == 'role' && $sortDir == 'asc' ? 'desc' : 'asc']) }}">
                                Vai trò <i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th>Trạng thái</th> {{-- Add Status Column --}}
                        <th>
                            @php $sortIcon = $sortBy == 'created_at' ? ($sortDir == 'asc' ? 'ti-arrow-up' : 'ti-arrow-down') : 'ti-arrows-sort'; @endphp
                            <a
                                href="{{ route('admin.users.index', ['sort_by' => 'created_at', 'sort_dir' => $sortBy == 'created_at' && $sortDir == 'asc' ? 'desc' : 'asc']) }}">
                                Ngày tạo <i class="ti {{ $sortIcon }}"></i>
                            </a>
                        </th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="text-center">{{  $user->id }}</td>
                            <td>
                                <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('admin/assets/images/user/avatar-2.jpg') }}"
                                    alt="Avatar" class="user-avtar" style="width: 40px; height: 40px; border-radius: 50%;"
                                    onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/user/avatar-2.jpg') }}';">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-primary">Quản trị viên</span>
                                @else
                                    <span class="badge bg-secondary">Người dùng</span>
                                @endif
                            </td>
                            <td> {{-- Status Column --}}
                                @if($user->trashed())
                                    <span class="badge bg-danger">Đã xóa</span>
                                @else
                                    <span class="badge bg-success">Hoạt động</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                @if($user->trashed())
                                    {{-- Restore Button --}}
                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="d-inline"> {{--
                                        Use update route for restore --}}
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="restore" value="1"> {{-- Add a flag for restore --}}
                                        <button type="submit" class="btn btn-sm btn-warning me-2" title="Khôi phục">
                                            <i class="fas fa-undo"></i> Khôi phục
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-primary me-2" disabled>
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    {{-- Optional: Add Force Delete Button --}}
                                    {{-- <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Xóa vĩnh viễn?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="force_delete" value="1">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa vĩnh viễn"><i
                                                class="fas fa-times"></i></button>
                                    </form> --}}
                                @else
                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    {{-- Soft Delete Button --}}
                                    @if(Auth::id() !== $user->id) {{-- Prevent deleting self --}}
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-sm btn-danger" disabled>
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Không có người dùng nào.</td> {{-- Incremented colspan --}}
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Re-add pagination links --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection