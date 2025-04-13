@extends('layouts.guest')
@section('content')
    {{-- Check if $newsItem exists --}}
    @if (isset($newsItem))
        <div class="single">
            {{-- Header with Background Image --}}
            <div id="fh5co-title-box"
                style="background-image: url({{ $newsItem->image ? Storage::url($newsItem->image) : asset('site/images/camila-cordeiro-114636.jpg') }}); background-position: center center;"
                {{-- Adjusted background position --}} data-stellar-background-ratio="0.5">
                <div class="overlay"></div>
                <div class="page-title">
                    {{-- Author Avatar (Check if user and avatar exist) --}}
                    @if ($newsItem->user && $newsItem->user->avatar)
                        <img src="{{ Storage::url($newsItem->user->avatar) }}" alt="{{ $newsItem->user->name }} Avatar"
                            onerror="this.onerror=null;this.src='{{ asset('site/images/person_1.jpg') }}';">
                    @else
                        <img src="{{ asset('site/images/person_1.jpg') }}" alt="Default Avatar">
                    @endif
                    {{-- Author Name and Date --}}
                    <span>
                        @if ($newsItem->user)
                            {{ $newsItem->user->name }} -
                        @endif
                        {{ $newsItem->created_at->format('M d, Y') }}
                    </span>
                    <span>
                        <a href="{{ route('category.show', $newsItem->category->slug) }}" class="badge bg-info"
                            style="width: fit-content; text-align: center;">
                            @if($newsItem->category)
                                {{ $newsItem->category->name }}
                            @endif
                        </a>

                    </span>
                    {{-- News Title --}}
                    <h2>{{ $newsItem->title }}</h2>
                    {{-- News Like Button --}}
                    <div class="mt-2">
                        @auth
                            <form action="{{ route('news.like', $newsItem->id) }}" method="POST" style="display: inline;">
                                @csrf
                                {{-- Check if current user ID exists in the eager-loaded likers collection --}}
                                @php $isLikedByCurrentUser = $newsItem->likers->contains(Auth::id()); @endphp
                                <button type="submit"
                                    class="btn btn-sm {{ $isLikedByCurrentUser ? 'btn-primary' : 'btn-outline-primary' }}">
                                    <i class="fa fa-thumbs-up"></i>
                                    {{ $isLikedByCurrentUser ? 'Bỏ thích' : 'Thích' }}
                                    ({{ $newsItem->likers->count() }}) {{-- Use count() on loaded collection --}}
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-sm btn-outline-primary" disabled>
                                <i class="fa fa-thumbs-up"></i> Thích ({{ $newsItem->likers->count() }}) {{-- Use count() on loaded
                                collection --}}
                            </button>
                            <small class="ms-2"><a href="{{ route('login') }}">Đăng nhập để thích</a></small>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- Main Content Area --}}
            <div id="fh5co-single-content" class="container-fluid pb-4 pt-4 paddding">
                <div class="container paddding">
                    <div class="row mx-0">
                        {{-- News Content Column --}}
                        <div class="col-md-8 animate-box" data-animate-effect="fadeInLeft">
                            {{-- Display HTML content safely --}}
                            {!! $newsItem->content !!}

                            {{-- Optional: Display Tags --}}
                            {{-- Decode JSON string and check if it's a non-empty array --}}
                            @php $tagsArray = json_decode($newsItem->tags, true); @endphp
                            @if (is_array($tagsArray) && !empty($tagsArray))
                                <div class="pt-4">
                                    <strong>Tags:</strong>
                                    {{-- Loop through the decoded tags array --}}
                                    @foreach ($tagsArray as $tag)
                                        @if ($tag) {{-- Check if tag is not empty/null --}}
                                            <a href="{{ route('news.by_tag', ['tag' => urlencode($tag)]) }}"
                                                class="badge bg-secondary text-decoration-none me-1">{{ $tag }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                        </div> {{-- End col-md-8 --}}

                        {{-- Sidebar --}}
                        @include('client.blocks.tag_tinhot')

                    </div> {{-- End row mx-0 --}}
                </div> {{-- End container paddding --}}
            </div> {{-- End fh5co-single-content --}}

            {{-- Include Comment Section --}}
            @include('client.blocks._comment_box', ['newsItem' => $newsItem])

            {{-- Moved Related News Section Here --}}
            @if (isset($relatedNews) && $relatedNews->count() > 0)
                <div class="container-fluid pb-4 pt-5"> {{-- Added container structure like trending block --}}
                    <div class="container animate-box">
                        <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Related News</div>
                        {{-- Use Owl Carousel structure like trending block, using ID slider2 --}}
                        <div class="owl-carousel owl-theme" id="slider2"> {{-- Reverted ID to slider2 --}}
                            @foreach ($relatedNews as $related)
                                <div class="item px-2">
                                    <div class="fh5co_hover_news_img">
                                        <div class="fh5co_news_img">
                                            <img src="{{ $related->image ? Storage::url($related->image) : asset('site/images/39-324x235.jpg') }}"
                                                alt="{{ $related->title }}"
                                                onerror="this.onerror=null;this.src='{{ asset('site/images/39-324x235.jpg') }}';" />
                                        </div>
                                        <div>
                                            <a href="{{ route('news.show', $related->slug) }}" class="d-block fh5co_small_post_heading">
                                                <span class="">{{ Str::limit($related->title, 55) }}</span>
                                            </a>
                                            <div class="c_g"><i class="fa fa-clock-o"></i> {{ $related->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Removed Trending Section Include was already done --}}
        </div> {{-- End single --}}
    @else
        {{-- Handle case where news item wasn't found (though controller uses firstOrFail) --}}
        <div class="container-fluid pb-4 pt-4 paddding">
            <div class="container paddding">
                <p class="text-center">Bài viết không tồn tại.</p>
            </div>
        </div>
    @endif
@endsection