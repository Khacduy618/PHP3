@extends('layouts.guest')
@section('content')
    <div class="container-fluid pb-4 pt-4 paddding">
        <div class="container paddding">
            <div class="row mx-0">
                <div class="col-md-8 animate-box" data-animate-effect="fadeInLeft">
                    {{-- Category Title --}}
                    <div>
                        <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">
                            {{-- Check if $category exists (for category page) or $tagName (for tag page) --}}
                            @isset($category)
                                Tin tức trong loại: {{ $category->name }}
                            @endisset
                        </div>
                    </div>

                    {{-- Sorting Dropdown --}}
                    <div class="d-flex justify-content-end mb-3">
                        <form
                            action="@if(is_null($category->parent_id)){{ route('category.parent.show', $category->slug) }}@else{{ route('category.show', $category->slug) }}@endif"
                            method="GET">
                            <select name="sort_by" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="date" {{ $sortBy == 'date' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="views" {{ $sortBy == 'views' ? 'selected' : '' }}>Xem nhiều</option>
                                <option value="likes" {{ $sortBy == 'likes' ? 'selected' : '' }}>Thích nhiều</option>
                                <option value="comments" {{ $sortBy == 'comments' ? 'selected' : '' }}>Bình luận nhiều
                                </option>
                            </select>
                            {{-- Keep other query parameters if any --}}
                            @foreach(request()->except(['sort_by', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        </form>
                    </div>

                    {{-- News List --}}
                    @if (isset($newsItems) && $newsItems->count() > 0)
                        @foreach ($newsItems as $news)
                            <div class="row py-4 border-bottom">
                                <div class="col-md-3 col-sm-12"> {{-- Adjusted column size for image --}}
                                    <div class="fh5co_hover_news_img">
                                        <div class="fh5co_news_img" style="height: 180px !important; overflow: hidden !important;">
                                            <a href="{{ route('news.show', $news->slug) }}" style="display: block; height: 100%;">
                                                <img src="{{ $news->image ? Storage::url($news->image) : asset('site/images/nathan-mcbride-229637.jpg') }}"
                                                    alt="{{ $news->title }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('site/images/nathan-mcbride-229637.jpg') }}';"
                                                    style="width: 100%; height: 100%; object-fit: cover;" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-12 animate-box"> {{-- Adjusted column size for text --}}
                                    <a href="{{ route('news.show', $news->slug) }}" class="fh5co_magna py-2 d-block">
                                        {{ $news->title }}
                                    </a>
                                    <div class="fh5co_mini_time pb-1">
                                        {{-- Display Category if available --}}
                                        @if ($news->category)
                                            <span class="badge bg-info me-2">{{ $news->category->name }}</span>
                                        @endif
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
                        <p class="text-center">Không có tin tức nào phù hợp.</p>
                    @endif
                </div>

                {{-- Include Sidebar (Requires data via Composer or passed from controller) --}}
                @include('client.blocks.tag_tinhot')
            </div>
        </div>
    </div>

    {{-- Include Trending Section (Requires data via Composer or passed from controller) --}}
    {{-- Consider removing this if not needed on category/tag pages --}}
    @include('client.blocks.trending')

@endsection