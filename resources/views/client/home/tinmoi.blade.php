@if (isset($latestNews) && $latestNews->count() > 0)
    <div class="container-fluid pb-4 pt-5">
        <div class="container animate-box">
            <div>
                <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Tin Mới Nhất</div> {{-- Changed heading
                --}}
            </div>
            <div class="owl-carousel owl-theme" id="slider2">
                @foreach ($latestNews as $news)
                    <div class="item px-2">
                        <div class="fh5co_hover_news_img">
                            <div class="fh5co_news_img">
                                <img src="{{ $news->image ? Storage::url($news->image) : asset('site/images/39-324x235.jpg') }}"
                                    alt="{{ $news->title }}"
                                    onerror="this.onerror=null;this.src='{{ asset('site/images/39-324x235.jpg') }}';" />
                            </div>
                            <div>
                                <a href="{{ route('news.show', $news->slug) }}" class="d-block fh5co_small_post_heading">
                                    <span class="">{{ Str::limit($news->title, 55) }}</span> {{-- Limit title length --}}
                                </a>
                                <div class="c_g">
                                    <i class="fa fa-clock-o"></i> {{ $news->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif