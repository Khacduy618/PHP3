@if (isset($trendingNews) && $trendingNews->count() > 0)
    <div class="container-fluid pt-3">
        <div class="container animate-box" data-animate-effect="fadeIn">
            <div>
                <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Trending</div>
            </div>
            <div class="owl-carousel owl-theme js" id="slider1">
                @foreach ($trendingNews as $news)
                    <div class="item px-2">
                        <div class="fh5co_latest_trading_img_position_relative">
                            <div class="fh5co_latest_trading_img">
                                <img src="{{ $news->image ? Storage::url($news->image) : asset('site/images/allef-vinicius-108153.jpg') }}"
                                    alt="{{ $news->title }}" class="fh5co_img_special_relative"
                                    onerror="this.onerror=null;this.src='{{ asset('site/images/allef-vinicius-108153.jpg') }}';" />
                            </div>
                            <div class="fh5co_latest_trading_img_position_absolute"></div>
                            <div class="fh5co_latest_trading_img_position_absolute_1">
                                <a href="{{ route('news.show', $news->slug) }}" class="text-white">
                                    {{ Str::limit($news->title, 60) }} {{-- Limit title length --}}
                                </a>
                                <div class="fh5co_latest_trading_date_and_name_color">
                                    {{-- Assuming User relationship exists: $news->user->name ?? 'Unknown Author' }} - --}}
                                    {{ $news->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif