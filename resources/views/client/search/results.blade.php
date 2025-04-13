@extends('layouts.guest')

@section('content')
    <div class="container-fluid pb-4 pt-4 paddding">
        <div class="container paddding">
            <div class="row mx-0">
                {{-- Main Content Area (col-md-8) --}}
                <div class="col-md-8 animate-box" data-animate-effect="fadeInLeft">
                    {{-- Search Title --}}
                    <div>
                        <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">
                            Kết quả tìm kiếm cho: "{{ $query }}"
                        </div>
                    </div>

                    {{-- News List --}}
                    @if (isset($newsItems) && $newsItems->count() > 0)
                        @foreach ($newsItems as $news)
                            <div class="row py-4 border-bottom">
                                <div class="col-md-3 col-sm-12">
                                    <div class="fh5co_hover_news_img">
                                        <div class="fh5co_news_img" style="height: 180px; overflow: hidden;"> {{-- Consistent height
                                            --}}
                                            <a href="{{ route('news.show', $news->slug) }}" style="display: block; height: 100%;">
                                                <img src="{{ $news->image ? Storage::url($news->image) : asset('site/images/nathan-mcbride-229637.jpg') }}"
                                                    alt="{{ $news->title }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('site/images/nathan-mcbride-229637.jpg') }}';"
                                                    style="width: 100%; height: 100%; object-fit: cover;" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-12 animate-box">
                                    <a href="{{ route('news.show', $news->slug) }}" class="fh5co_magna py-2 d-block">
                                        {{ $news->title }}
                                    </a>
                                    <div class="fh5co_mini_time pb-1">
                                        @if ($news->category)
                                            <span class="badge bg-info me-2">{{ $news->category->name }}</span>
                                        @endif
                                        @if ($news->user)
                                            <span class="me-2"><i class="fa fa-user"></i> {{ $news->user->name }}</span>
                                        @endif
                                        <i class="fa fa-clock-o"></i> {{ $news->created_at->format('M d, Y') }}
                                        @if (isset($news->views))
                                            <span class="ms-2"><i class="fa fa-eye"></i> {{ $news->views }}</span>
                                        @endif
                                    </div>
                                    <div class="fh5co_consectetur">
                                        {{ Str::limit($news->summary ?? $news->content, 200) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Pagination Links --}}
                        <div class="row justify-content-center pt-4">
                            <div class="col-md-12 text-center">
                                {{-- Make sure pagination links include the search query --}}
                                {{ $newsItems->appends(['query' => $query])->links() }}
                            </div>
                        </div>
                    @else
                        <p class="text-center">Không tìm thấy bài viết nào phù hợp với từ khóa "{{ $query }}".</p>
                    @endif
                </div>

                {{-- Sidebar --}}
                @include('client.blocks.tag_tinhot')
            </div>
        </div>
    </div>

    {{-- Trending Section --}}
    @include('client.blocks.trending')

@endsection