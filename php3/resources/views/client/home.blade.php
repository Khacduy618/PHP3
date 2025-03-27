@extends('layouts.client')
@section('content')

    <div class="trending-area fix">
        <div class="container">
            <div class="trending-main">
                <!-- Trending Tittle -->
                <!-- <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="trending-tittle">
                                                                <strong>Trending now</strong>

                                                                <div class="trending-animated">
                                                                    <ul id="js-news" class="js-hidden">
                                                                        <li class="news-item">Bangladesh dolor sit amet, consectetur adipisicing elit.</li>
                                                                        <li class="news-item">Spondon IT sit amet, consectetur.......</li>
                                                                        <li class="news-item">Rem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div> -->
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Trending Top -->
                        @if($latestNews)
                            <div class="trending-top mb-30">
                                <div class="trend-top-img">
                                    <!-- <img src="{{ asset('public/uploads/news/' . $latestNews->image) }}" alt=""> -->
                                    <img src="assets/img/trending/trending_top.jpg" alt="">
                                    <div class="trend-top-cap">
                                        <span>{{ $latestNews->category_name }}</span>
                                        <h2><a
                                                href="{{ route('news.detail', ['slug' => $latestNews->slug]) }}">{{ $latestNews->title }}</a>
                                        </h2>
                                        <p class="text-white">
                                            {{ \Carbon\Carbon::parse($latestNews->created_at)->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- Trending Bottom -->
                        <div class="trending-bottom">
                            <div class="row">
                                @foreach($nextThreeNews as $news)
                                    <div class="col-lg-4">
                                        <div class="single-bottom mb-35">
                                            <div class="trend-bottom-img mb-30">
                                                <!-- <img src="{{ asset('public/uploads/news/' . $news->image) }}" alt=""> -->
                                                <img src="assets/img/trending/trending_bottom1.jpg" alt="">
                                            </div>
                                            <div class="trend-bottom-cap">
                                                <span class="color1">{{ $news->category_name }}</span>
                                                <h4><a
                                                        href="{{ route('news.detail', ['slug' => $news->slug]) }}">{{ $news->title }}</a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <!-- Riht content -->
                    <div class="col-lg-4">
                        @foreach($nextFiveNews as $news)
                            <div class="trand-right-single d-flex">
                                <div class="trand-right-img">
                                    <!-- <img src="{{ asset('public/uploads/news/' . $news->image) }}" alt=""> -->
                                    <img src="assets/img/trending/right1.jpg" alt="">
                                </div>
                                <div class="trand-right-cap">
                                    <span class="color1">{{ $news->category_name }}</span>
                                    <h4><a href="{{ route('news.detail', ['slug' => $news->slug]) }}">{{ $news->title }}</a>
                                    </h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Trending Area End -->
    <!--   Weekly-News start -->
    <div class="weekly-news-area pt-50">
        <div class="container">
            <div class="weekly-wrapper">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>Weekly Top News</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="weekly-news-active dot-style d-flex dot-style">
                            @foreach($mostCommentedNews as $news)
                                <div class="weekly-single">
                                    <div class="weekly-img">
                                        <!-- <img src="{{ asset('public/uploads/news/' . $news->image) }}" alt=""> -->
                                        <img src="assets/img/news/weeklynews1.jpg" alt="">
                                    </div>
                                    <div class="weekly-caption">
                                        <span class="color1">{{ $news->category_name }}</span>
                                        <h4><a href="{{ route('news.detail', ['slug' => $news->slug]) }}">{{ $news->title }}</a></h4>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Weekly-News -->
    <!-- Whats New Start -->
    <section class="whats-news-area pt-50 pb-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row d-flex justify-content-between">
                        <div class="col-lg-3 col-md-3">
                            <div class="section-tittle mb-30">
                                <h3>Whats New</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="properties__button">
                                <!--Nav Button  -->
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <!-- <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">All</a> -->
                                        @foreach ($categories as $category)
                                                <a class="nav-item  px-2 py-2 nav-link {{ $loop->first ? 'active' : '' }}"
                                                id="nav-{{ $category->id }}-tab" data-toggle="tab"
                                                href="#nav-{{ $category->id }}"
                                                aria-controls="nav-{{ $category->id }}"
                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                                >
                                                    {{ $category->name }}
                                                </a>
                                            @endforeach
                                    </div>
                                </nav>
                                <!--End Nav Button  -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <!-- Nav Card -->
                            <div class="tab-content" id="nav-tabContent">
                                <!-- card one -->
                                <div class="tab-pane fade show active" id="nav-1" role="tabpanel"
                                    aria-labelledby="nav-1-tab">
                                    <div class="whats-news-caption">
                                        <div class="row">
                                            @foreach($newsByCategory1 as $news)
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="single-what-news mb-100">
                                                        <div class="what-img">
                                                            <!-- <img src="{{ asset('public/uploads/news/' . $news->image) }}" alt=""> -->
                                                            <img src="assets/img/news/whatNews1.jpg" alt="">
                                                        </div>
                                                        <div class="what-cap">
                                                            <span class="color1">{{ $news->category_name }}</span>
                                                            <h4><a href="{{ route('news.detail', ['slug' => $news->slug]) }}">{{ $news->title }}</a></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                           
                                        </div>
                                    </div>
                                </div>
                                <!-- Card two -->
                                <div class="tab-pane fade" id="nav-2" role="tabpanel"
                                    aria-labelledby="nav-2-tab">
                                    <div class="whats-news-caption">
                                        <div class="row">
                                        @foreach($newsByCategory2 as $news)
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="single-what-news mb-100">
                                                        <div class="what-img">
                                                            <!-- <img src="{{ asset('public/uploads/news/' . $news->image) }}" alt=""> -->
                                                            <img src="assets/img/news/whatNews2.jpg" alt="">
                                                        </div>
                                                        <div class="what-cap">
                                                            <span class="color1">{{ $news->category_name }}</span>
                                                            <h4><a href="{{ route('news.detail', ['slug' => $news->slug]) }}">{{ $news->title }}</a></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- Card three -->
                                <div class="tab-pane fade" id="nav-3" role="tabpanel"
                                    aria-labelledby="nav-3-tab">
                                    <div class="whats-news-caption">
                                        <div class="row">
                                        @foreach($newsByCategory3 as $news)
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="single-what-news mb-100">
                                                        <div class="what-img">
                                                            <!-- <img src="{{ asset('public/uploads/news/' . $news->image) }}" alt=""> -->
                                                            <img src="assets/img/news/whatNews1.jpg" alt="">
                                                        </div>
                                                        <div class="what-cap">
                                                            <span class="color1">{{ $news->category_name }}</span>
                                                            <h4><a href="{{ route('news.detail', ['slug' => $news->slug]) }}">{{ $news->title }}</a></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- card fure -->
                                <div class="tab-pane fade" id="nav-4" role="tabpanel" aria-labelledby="nav-4-tab">
                                    <div class="whats-news-caption">
                                        <div class="row">
                                        @foreach($newsByCategory4 as $news)
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="single-what-news mb-100">
                                                        <div class="what-img">
                                                            <!-- <img src="{{ asset('public/uploads/news/' . $news->image) }}" alt=""> -->
                                                            <img src="assets/img/news/whatNews1.jpg" alt="">
                                                        </div>
                                                        <div class="what-cap">
                                                            <span class="color1">{{ $news->category_name }}</span>
                                                            <h4><a href="{{ route('news.detail', ['slug' => $news->slug]) }}">{{ $news->title }}</a></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- card Five -->
                                <div class="tab-pane fade" id="nav-5" role="tabpanel" aria-labelledby="nav-5">
                                    <div class="whats-news-caption">
                                        <div class="row">
                                        @foreach($newsByCategory5 as $news)
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="single-what-news mb-100">
                                                        <div class="what-img">
                                                            <!-- <img src="{{ asset('public/uploads/news/' . $news->image) }}" alt=""> -->
                                                            <img src="assets/img/news/whatNews1.jpg" alt="">
                                                        </div>
                                                        <div class="what-cap">
                                                            <span class="color1">{{ $news->category_name }}</span>
                                                            <h4><a href="{{ route('news.detail', ['slug' => $news->slug]) }}">{{ $news->title }}</a></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- card Six -->
                                <div class="tab-pane fade" id="nav-6" role="tabpanel" aria-labelledby="nav-6">
                                    <div class="whats-news-caption">
                                        <div class="row">
                                        @foreach($newsByCategory6 as $news)
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="single-what-news mb-100">
                                                        <div class="what-img">
                                                            <!-- <img src="{{ asset('public/uploads/news/' . $news->image) }}" alt=""> -->
                                                            <img src="assets/img/news/whatNews1.jpg" alt="">
                                                        </div>
                                                        <div class="what-cap">
                                                            <span class="color1">{{ $news->category_name }}</span>
                                                            <h4><a href="{{ route('news.detail', ['slug' => $news->slug]) }}">{{ $news->title }}</a></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Nav Card -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Section Tittle -->
                    <div class="section-tittle mb-40">
                        <h3>Follow Us</h3>
                    </div>
                    <!-- Flow Socail -->
                    <div class="single-follow mb-45">
                        <div class="single-box">
                            <div class="follow-us d-flex align-items-center">
                                <div class="follow-social">
                                    <a href="#"><img src="assets/img/news/icon-fb.png" alt=""></a>
                                </div>
                                <div class="follow-count">
                                    <span>8,045</span>
                                    <p>Fans</p>
                                </div>
                            </div>
                            <div class="follow-us d-flex align-items-center">
                                <div class="follow-social">
                                    <a href="#"><img src="assets/img/news/icon-tw.png" alt=""></a>
                                </div>
                                <div class="follow-count">
                                    <span>8,045</span>
                                    <p>Fans</p>
                                </div>
                            </div>
                            <div class="follow-us d-flex align-items-center">
                                <div class="follow-social">
                                    <a href="#"><img src="assets/img/news/icon-ins.png" alt=""></a>
                                </div>
                                <div class="follow-count">
                                    <span>8,045</span>
                                    <p>Fans</p>
                                </div>
                            </div>
                            <div class="follow-us d-flex align-items-center">
                                <div class="follow-social">
                                    <a href="#"><img src="assets/img/news/icon-yo.png" alt=""></a>
                                </div>
                                <div class="follow-count">
                                    <span>8,045</span>
                                    <p>Fans</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- New Poster -->
                    <div class="news-poster d-none d-lg-block">
                        <img src="assets/img/news/news_card.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Whats New End -->
    <!--   Weekly2-News start -->
    <div class="weekly2-news-area  weekly2-pading gray-bg">
        <div class="container">
            <div class="weekly2-wrapper">
                <!-- section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle mb-30">
                            <h3>MOST VIEW</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="weekly2-news-active dot-style d-flex dot-style">
                            @foreach($mostViewedNews as $news)
                                <div class="weekly2-single">
                                    <div class="weekly2-img">
                                        <img src="assets/img/news/weekly2News1.jpg" alt="">
                                    </div>
                                    <div class="weekly2-caption">
                                        <span class="color1">{{ $news->category_name }}</span>
                                        <p>{{ \Carbon\Carbon::parse($news->created_at)->format('d M Y') }}</p>
                                        <h4><a href="{{ route('news.detail', ['slug' => $news->slug]) }}">{{ $news->title }}</a></h4>
                                        <p>Views: {{ $news->views }}</p>
                                    </div>
                                </div>
                            @endforeach
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Weekly-News -->
  
    
@endsection