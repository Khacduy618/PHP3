@extends('layouts.server')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ $title }}</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">Thêm Người dùng</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Ảnh đại diện</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th> {{-- Add Status Column --}}
                        <th>Ngày tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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

        </div>
    </div>
@endsection