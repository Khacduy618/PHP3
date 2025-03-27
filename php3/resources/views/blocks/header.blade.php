<div class="header-area">
    <div class="main-header ">
        <div class="header-top black-bg d-none d-md-block">
            <div class="container">
                <div class="col-xl-12">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="header-info-left">
                            <ul>
                                <li><img src="assets/img/icon/header_icon1.png" alt="">34ºc, Sunny </li>
                                <li><img src="assets/img/icon/header_icon1.png" alt="">Tuesday, 18th June, 2019</li>
                            </ul>
                        </div>
                        <div class="header-info-right">
                            <ul class="header-social">
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li> <a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-mid d-none d-md-block">
            <div class="container">
                <div class="row d-flex align-items-center">
                    <!-- Logo -->
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="logo">
                            <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo/logo.png') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 d-flex justify-content-end align-items-center">
                        @if(Auth::check())
                            <!-- Hiển thị tên người dùng và dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <!-- Hiển thị nút SignIn và Login -->
                            <a href="{{ route('register.form') }}" class="butn">SignIn</a>
                            <a href="{{ route('login.form') }}" class="butn">Login</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-10 col-lg-10 col-md-12 header-flex">
                        <!-- sticky -->
                        <div class="sticky-logo">
                            <a href="index.html"><img src="{{ asset('assets/img/logo/logo.png') }}" alt=""></a>
                        </div>
                        <!-- Main-menu -->
                        <div class="main-menu d-none d-md-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                                    @foreach ($categories as $category)
                                        <li><a
                                                href="{{ route('category.news', ['slug' => $category->slug]) }}">{{$category->name}}</a>
                                        </li>

                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4">
                        <div class="header-right-btn f-right d-none d-lg-block">
                            <i class="fas fa-search special-tag"></i>
                            <div class="search-box">
                                <form action="#">
                                    <input type="text" placeholder="Search">

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-md-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<script>
    // Tự động ẩn thông báo sau 5 giây
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.classList.remove('show');
            alert.classList.add('fade');
        });
    }, 5000);
</script>