@extends('layouts.guest')

@section('content')
    <div class="container-fluid pb-4 pt-4 paddding">
        <div class="container paddding">
            <div class="row mx-0">
                <div class="col-md-12 animate-box" data-animate-effect="fadeInLeft">
                    {{-- Category Title --}}
                    <div>
                        <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">
                            Danh mục: {{ $category->name }}
                        </div>
                    </div>

                    {{-- News List --}}
                    @if ($newsItems->count() > 0)
                        @foreach ($newsItems as $news)
                            <div class="row py-4 border-bottom">
                                <div class="col-md-3 col-sm-12"> {{-- Adjusted column size for image --}}
                                    <div class="fh5co_hover_news_img">
                                        <div class="fh5co_news_img">
                                            <a href="{{ route('news.show', $news->slug) }}">
                                                <img src="{{ $news->image ? Storage::url($news->image) : asset('site/images/nathan-mcbride-229637.jpg') }}"
                                                    alt="{{ $news->title }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('site/images/nathan-mcbride-229637.jpg') }}';"
                                                    style="width: 100%; height: auto; object-fit: cover;" /> {{-- Basic styling --}}
                                            </a>
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-12 animate-box"> {{-- Adjusted column size for text --}}
                                    <a href="{{ route('news.show', $news->slug) }}" class="fh5co_magna py-2 d-block">
                                        {{ $news->title }}
                                    </a>
                                    <div class="fh5co_mini_time pb-1">
                                        {{-- Display Author if available --}}
                                        @if ($news->user)
                                            <span class="me-2"><i class="fa fa-user"></i> {{ $news->user->name }}</span>
                                        @endif
                                        <i class="fa fa-clock-o"></i> {{ $news->created_at->format('M d, Y') }}
                                        {{-- Display Views if available --}}
                                        @if (isset($news->views))
                                            <span class="ms-2"><i class="fa fa-eye"></i> {{ $news->views }}</span>
                                        @endif
                                    </div>
                                    <div class="fh5co_consectetur">
                                        {{ Str::limit($news->summary ?? $news->content, 200) }} {{-- Use summary or limit content
                                        --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Pagination Links --}}
                        <div class="row justify-content-center pt-4">
                            <div class="col-md-12 text-center">
                                {{ $newsItems->links() }} {{-- Render pagination links --}}
                            </div>
                        </div>
                    @else
                        <p class="text-center">Không có tin tức nào trong danh mục này.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection