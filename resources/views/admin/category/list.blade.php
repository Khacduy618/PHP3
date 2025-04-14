@extends('layouts.server')

@section('content')
    <h2>Danh sách Danh Mục</h2>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y') }}</td>

                            <td>
                                @if($category->status === 'Ẩn')
                                    <form action="{{ route('admin.category.show', ['slug' => $category->slug]) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Hiện">
                                        <button type="submit" class="btn btn-sm btn-danger d-inline-block w-100"
                                            onclick="return confirm('Bạn có chắc chắn muốn hiện?')">
                                            Ẩn
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.category.hide', ['slug' => $category->slug]) }}" method="POST"
                                        class="d-inline">
                                        @csrf

                                        <input type="hidden" name="status" value="Ẩn">
                                        <button type="submit" class="btn btn-sm btn-success d-inline-block w-100"
                                            onclick="return confirm('Bạn có chắc chắn muốn ẩn?')">
                                            Hiện
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="text-center d-flex">
                                <a href="{{ route('admin.category.edit', ['slug' => $category->slug]) }}"
                                    class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-edit"></i> </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection