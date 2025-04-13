{{-- Check if trendingNews exists and is not empty --}}
@if (isset($trendingNews) && $trendingNews->count() > 0)
    <div class="container-fluid pb-4 pt-5">
        <div class="container animate-box">
            <div>
                <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Trending</div>
            </div>
            {{-- Keep original Owl Carousel ID and classes --}}
            <div class="owl-carousel owl-theme" id="slider2">
                {{-- Loop through trending news --}}
                @foreach ($trendingNews as $news)
                    <div class="item px-2">
                        <div class="fh5co_hover_news_img">
                            <div class="fh5co_news_img">
                                <img src="{{ $news->image ? Storage::url($news->image) : asset('site/images/39-324x235.jpg') }}"
                                    alt="{{ $news->title }}"
                                    onerror="this.onerror=null;this.src='{{ asset('site/images/39-324x235.jpg') }}';" />
                            </div>
                            <div>
                                <a href="{{ route('news.show', $news->slug) }}" class="d-block fh5co_small_post_heading">
                                    <span class="">{{ Str::limit($news->title, 55) }}</span>
                                </a>
                                <div class="c_g"><i class="fa fa-clock-o"></i> {{ $news->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif