<div class="col-md-3 animate-box" data-animate-effect="fadeInRight">
    {{-- Tags Section --}}
    @if (isset($allTags) && !empty($allTags))
        <div>
            <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Tags</div>
        </div>
        <div class="clearfix"></div>
        <div class="fh5co_tags_all " style="min-height: 300px;">
            @foreach ($allTags as $tag)
                {{-- Assuming a route like 'news.by_tag' exists --}}
                <a href="{{ route('news.by_tag', ['tag' => urlencode($tag)]) }}" class="fh5co_tagg">{{ $tag }}</a>
            @endforeach
        </div>
    @endif

    {{-- Hot News Section --}}
    @if (isset($hotNews) && $hotNews->count() > 0)
        <div>
            <div class="fh5co_heading fh5co_heading_border_bottom pt-3 py-2 mb-4">Tin Hot</div> {{-- Changed heading --}}
        </div>
        @foreach ($hotNews as $news)
            <div class="row pb-3">
                <div class="col-5 align-self-center">
                    <img src="{{ $news->image ? Storage::url($news->image) : asset('site/images/download (1).jpg') }}"
                        alt="{{ $news->title }}" class="fh5co_most_trading"
                        onerror="this.onerror=null;this.src='{{ asset('site/images/download (1).jpg') }}';" />
                </div>
                <div class="col-7 paddding">
                    <a href="{{ route('news.show', $news->slug) }}" class="most_fh5co_treding_font d-block"> {{-- Added link and
                        d-block --}}
                        {{ Str::limit($news->title, 50) }}
                    </a>
                    <div class="most_fh5co_treding_font_123">
                        <i class="fa fa-clock-o"></i> {{ $news->created_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>