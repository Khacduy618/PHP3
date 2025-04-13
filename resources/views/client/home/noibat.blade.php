@if (isset($featuredNews) && $featuredNews->count() > 0)
    <div class="container-fluid paddding mb-5">
        <div class="row mx-0">
            @php $firstFeatured = $featuredNews->first(); @endphp
            <div class="col-md-6 col-12 paddding animate-box" data-animate-effect="fadeIn">
                <div class="fh5co_suceefh5co_height">
                    {{-- Use Storage::url if image path is relative to storage, otherwise use asset() --}}
                    <img src="{{ $firstFeatured->image ? Storage::url($firstFeatured->image) : asset('site/images/nick-karvounis-78711.jpg') }}"
                        alt="{{ $firstFeatured->title }}"
                        onerror="this.onerror=null;this.src='{{ asset('site/images/nick-karvounis-78711.jpg') }}';" />
                    <div class="fh5co_suceefh5co_height_position_absolute"></div>
                    <div class="fh5co_suceefh5co_height_position_absolute_font">
                        <div class="p-2">
                            <a href="{{ route('news.show', $firstFeatured->slug) }}" class="color_fff">
                                <i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ $firstFeatured->created_at->format('M d, Y') }}
                            </a>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('news.show', $firstFeatured->slug) }}" class="fh5co_good_font">
                                {{ $firstFeatured->title }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    @foreach ($featuredNews->slice(1, 4) as $news)
                        <div class="col-md-6 col-6 paddding animate-box" data-animate-effect="fadeIn">
                            <div class="fh5co_suceefh5co_height_2">
                                <img src="{{ $news->image ? Storage::url($news->image) : asset('site/images/science-578x362.jpg') }}"
                                    alt="{{ $news->title }}"
                                    onerror="this.onerror=null;this.src='{{ asset('site/images/science-578x362.jpg') }}';" />
                                <div class="fh5co_suceefh5co_height_position_absolute"></div>
                                <div class="fh5co_suceefh5co_height_position_absolute_font_2">
                                    <div class="">
                                        <a href="{{ route('news.show', $news->slug) }}" class="color_fff">
                                            <i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ $news->created_at->format('M d, Y') }}
                                        </a>
                                    </div>
                                    <div class="">
                                        <a href="{{ route('news.show', $news->slug) }}" class="fh5co_good_font_2">
                                            {{ Str::limit($news->title, 50) }} {{-- Limit title length --}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif