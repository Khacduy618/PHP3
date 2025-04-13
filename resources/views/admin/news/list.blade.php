@extends('layouts.server')

@section('content')
    <h2>Danh sách Tin Tức</h2>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Ngày tạo</th>
                        <th>Danh mục</th>
                        <th>Người tạo</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $item->category_name }}</td>
                            <td>{{ $item->author }}</td>
                            <td>
                                @if($item->status === 'published')
                                    <span class="badge bg-success">Xuất bản</span>
                                @else
                                    <span class="badge bg-warning text-dark">Nháp</span>
                                @endif
                            </td>
                            <td class="text-center d-flex">
                                <a href="{{ route('admin.news.edit', ['slug' => $item->slug]) }}"
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