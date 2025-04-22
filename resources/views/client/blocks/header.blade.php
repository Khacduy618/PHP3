<div class="container-fluid fh5co_header_bg">
    <div class="container">
        <div class="row">
            <div class="col-10 fh5co_mediya_center"><a href="#" class="color_fff fh5co_mediya_setting"><i
                        class="fa fa-clock-o"></i>&nbsp;&nbsp;&nbsp;Thứ Sáu, 5 tháng 1 2018</a>
                <div class="d-inline-block fh5co_trading_posotion_relative"><a href="#" class="treding_btn">Xu Hướng</a>
                    <div class="fh5co_treding_position_absolute"></div>
                </div>
                <a href="#" class="color_fff fh5co_mediya_setting">Thiết kế lại lớn của Instagram ra mắt với
                    ứng dụng đen trắng</a>
            </div>
            {{-- Moved Auth Block Here --}}
            <div class="col-2 ms-auto d-flex justify-content-center align-items-center">
                @guest
                    {{-- Show Login/Register if guest --}}
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn color_fff fh5co_mediya_setting"
                            style="text-decoration: none; margin-right: 10px;">Đăng nhập</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="color_fff fh5co_mediya_setting"
                            style="text-decoration: none;">Đăng ký</a>
                    @endif
                @else
                    <div class="img-avatar"
                        style="width: 35px; height: 35px; border-radius: 50%; overflow: hidden; margin-right: 5px; vertical-align: middle;">
                        <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('site/images/person_1.jpg') }}"
                            alt="{{ Auth::user()->name }}" style="max-width:100%; object-fit: cover;"
                            onerror="this.onerror=null;this.src='{{ asset('site/images/person_1.jpg') }}';">
                    </div>
                    {{-- Show User Dropdown if logged in --}}
                    <div class="dropdown" style="display: inline-block;"> {{-- Use inline-block for dropdown --}}

                        <a class="color_fff fh5co_mediya_setting dropdown-toggle" href="#" role="button"
                            id="userDropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"
                            style="text-decoration: none;">

                            <span style="vertical-align: middle;">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdownMenuLink"
                            style="min-width: auto; font-size: 0.9rem;"> {{-- Adjusted dropdown style --}}

                            {{-- Admin Link (Conditional) - Assuming 'admin' role and 'admin.dashboard' route --}}
                            @if (Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Quản trị</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endif
                            <li>
                                {{-- Logout Form --}}
                                <form method="POST" action="{{ route('logout') }}" id="logout-form" style="margin: 0;">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Đăng xuất
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 fh5co_padding_menu">
                <img src="{{ asset('site/images/logo.png') }}" alt="img" class="fh5co_logo_width" />
            </div>
            <div class="col-12 col-md-9 align-self-center fh5co_mediya_right">
                {{-- Search Form --}}
                <div class="text-center d-inline-block">
                    {{-- Search Icon Toggle --}}
                    <a href="#" class="fh5co_display_table" id="search-icon-toggle">
                        <div class="fh5co_verticle_middle"><i class="fa fa-search"></i></div>
                    </a>
                    {{-- Search Input Box (Initially Hidden) --}}
                    <form action="{{ route('news.search') }}" method="GET" id="search-form"
                        style="display: none; position: absolute; top: 5px; right: 300px; z-index: 1000; background: white; padding: 5px; border: 1px solid #ccc; border-radius: 5px;">
                        <input type="text" name="query" placeholder="Tìm kiếm tin tức..." required
                            style="border: none; outline: none; padding: 5px;">
                        <button type="submit"
                            style="background: none; border: none; padding: 0 5px; cursor: pointer;"><i
                                class="fa fa-search"></i></button>
                    </form>
                </div>
                {{-- Social Icons etc. --}}
                <div class="text-center d-inline-block">
                    <a class="fh5co_display_table">
                        <div class="fh5co_verticle_middle"><i class="fa fa-linkedin"></i></div>
                    </a>
                </div>
                <div class="text-center d-inline-block">
                    <a class="fh5co_display_table">
                        <div class="fh5co_verticle_middle"><i class="fa fa-google-plus"></i></div>
                    </a>
                </div>
                <div class="text-center d-inline-block">
                    <a href="https://twitter.com/fh5co" target="_blank" class="fh5co_display_table">
                        <div class="fh5co_verticle_middle"><i class="fa fa-twitter"></i></div>
                    </a>
                </div>
                <div class="text-center d-inline-block">
                    <a href="https://fb.com/fh5co" target="_blank" class="fh5co_display_table">
                        <div class="fh5co_verticle_middle"><i class="fa fa-facebook"></i></div>
                    </a>
                </div>
                <!--<div class="d-inline-block text-center"><img src="{{ asset('site/images/country.png') }}" alt="img" class="fh5co_country_width"/></div>-->
                <div class="d-inline-block text-center dd_position_relative ">
                    <select class="form-control fh5co_text_select_option">
                        <option value="">Tiếng Việt</option>
                        <option>Tiếng Anh </option>
                        <option>Tiếng Pháp </option>
                        <option>Tiếng Đức </option>
                        <option>Tiếng Tây Ban Nha </option>
                    </select>
                </div>

                {{-- Authentication Links/Dropdown (REMOVED FROM HERE) --}}
                {{-- <div class="text-center d-inline-block ms-2"> ... @guest ... @else ... @endguest ... </div> --}}

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

{{-- Add this script section at the end or integrate into your main JS --}}
{{-- Ensure the layout file has @stack('scripts') before closing </body> tag --}}
@push('scripts')
    <script>
        // Use a closure to avoid polluting global scope
        (function ($) {
            $(document).ready(function () {
                $('#search-icon-toggle').on('click', function (e) {
                    e.preventDefault(); // Prevent default link behavior
                    var $searchForm = $('#search-form');
                    $searchForm.toggle(); // Toggle visibility of the form
                    if ($searchForm.is(':visible')) {
                        $searchForm.find('input[name="query"]').focus(); // Focus the input field when shown
                    }
                });

                // Optional: Hide form if clicked outside
                $(document).on('click', function (event) {
                    var $target = $(event.target);
                    var $searchForm = $('#search-form');
                    if (!$target.closest('#search-form').length && !$target.closest('#search-icon-toggle').length) {
                        if ($searchForm.is(':visible')) {
                            $searchForm.hide();
                        }
                    }
                });
            });
        })(jQuery); // Pass jQuery to the closure
    </script>
@endpush