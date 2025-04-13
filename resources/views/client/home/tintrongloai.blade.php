@if (isset($parentCategories) && $parentCategories->count() > 0 && isset($newsByParentCategory) && !empty($newsByParentCategory))
    <div class="col-md-8 animate-box" data-animate-effect="fadeInLeft">
        <div>
            {{-- Use a generic title or loop through parent category names if needed --}}
            <div class="fh5co_heading fh5co_heading_border_bottom py-2 mb-4">Tin Tức Theo Loại</div>
        </div>

        {{-- Nav tabs --}}
        <ul class="nav nav-tabs" id="categoryTab" role="tablist">
            @foreach ($parentCategories as $index => $parentCategory)
                {{-- Check if there is news for this parent category before creating the tab --}}
                @if (isset($newsByParentCategory[$parentCategory->id]) && $newsByParentCategory[$parentCategory->id]->count() > 0)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="cat-tab-{{ $parentCategory->id }}"
                            data-bs-toggle="tab" data-bs-target="#cat-pane-{{ $parentCategory->id }}" type="button" role="tab"
                            aria-controls="cat-pane-{{ $parentCategory->id }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                            {{ $parentCategory->name }}
                        </button>
                    </li>
                @endif
            @endforeach
        </ul>

        {{-- Tab panes --}}
        <div class="tab-content" id="categoryTabContent">
            @foreach ($parentCategories as $index => $parentCategory)
                @if (isset($newsByParentCategory[$parentCategory->id]) && $newsByParentCategory[$parentCategory->id]->count() > 0)
                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="cat-pane-{{ $parentCategory->id }}"
                        role="tabpanel" aria-labelledby="cat-tab-{{ $parentCategory->id }}" tabindex="0">

                        @foreach ($newsByParentCategory[$parentCategory->id] as $news)
                            <div class="row py-4 border-bottom"> {{-- Added border for separation --}}
                                <div class="col-md-5 col-sm-12">
                                    <div class="fh5co_hover_news_img">
                                        <div class="fh5co_news_img">
                                            <img src="{{ $news->image ? Storage::url($news->image) : asset('site/images/nathan-mcbride-229637.jpg') }}"
                                                alt="{{ $news->title }}"
                                                onerror="this.onerror=null;this.src='{{ asset('site/images/nathan-mcbride-229637.jpg') }}';" />
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-12 animate-box">
                                    <a href="{{ route('news.show', $news->slug) }}" class="fh5co_magna py-2 d-block">
                                        {{ $news->title }}
                                    </a>
                                    <div class="fh5co_mini_time pb-1">
                                        @if ($news->category) {{-- Check if category exists --}}
                                            <span class="badge bg-info me-2">{{ $news->category->name }}</span> {{-- Changed background to bg-info --}}
                                        @endif
                                        <i class="fa fa-clock-o"></i> {{ $news->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="fh5co_consectetur">
                                        {{ Str::limit($news->summary ?? $news->content, 150) }} {{-- Use summary or limit content --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
