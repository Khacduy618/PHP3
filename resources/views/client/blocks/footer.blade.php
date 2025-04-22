<div class="container-fluid fh5co_footer_bg pb-3">
    <div class="container animate-box">
        <div class="row">
            <div class="col-12 spdp_right py-5"><img src="{{ asset('site/images/white_logo.png') }}" alt="img"
                    class="footer_logo" />
            </div>
            <div class="clearfix"></div>
            <div class="col-12 col-md-4 col-lg-3">
                <div class="footer_main_title py-3"> Về chúng tôi</div>
                <div class="footer_sub_about pb-3">Ngày thành lập: 14/04/2025</div>
                <div class="footer_sub_about pb-3"> Tổng biên tập: Nguyễn Khắc Duy</div>
                <div class="footer_mediya_icon">
                    <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                            <div class="fh5co_verticle_middle"><i class="fa fa-linkedin"></i></div>
                        </a></div>
                    <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                            <div class="fh5co_verticle_middle"><i class="fa fa-google-plus"></i></div>
                        </a></div>
                    <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                            <div class="fh5co_verticle_middle"><i class="fa fa-twitter"></i></div>
                        </a></div>
                    <div class="text-center d-inline-block"><a class="fh5co_display_table_footer">
                            <div class="fh5co_verticle_middle"><i class="fa fa-facebook"></i></div>
                        </a></div>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-2">
                <div class="footer_main_title py-3"> Danh mục</div>
                <ul class="footer_menu">
                    {{-- Loop through categories from FooterComposer --}}
                    @isset($footerCategories)
                        @foreach ($footerCategories as $category)
                            <li><a href="{{ route('category.parent.show', $category->slug) }}" class=""><i
                                        class="fa fa-angle-right"></i>&nbsp;&nbsp; {{ $category->name }}</a></li>
                        @endforeach
                    @endisset
                </ul>
            </div>
            <div class="col-12 col-md-5 col-lg-3 position_footer_relative">
                <div class="footer_main_title py-3"> Bài viết xem nhiều nhất</div>
                {{-- Loop through most viewed posts from FooterComposer --}}
                @isset($mostViewedPosts)
                    @foreach ($mostViewedPosts as $post)
                        <div class="footer_makes_sub_font"> {{ $post->created_at->format('d M, Y') }}</div>
                        <a href="{{ route('news.show', $post->slug) }}" class="footer_post pb-4">
                            {{ Str::limit($post->title, 60) }} </a>
                    @endforeach
                @endisset
                {{-- Keep the decorative image if desired --}}
                <div class="footer_position_absolute"><img src="{{ asset('site/images/footer_sub_tipik.png') }}"
                        alt="img" class="width_footer_sub_img" /></div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 ">
                <div class="footer_main_title py-3"> Hình ảnh mới nhất</div> {{-- Changed title slightly --}}
                {{-- Loop through latest posts images from FooterComposer --}}
                @isset($latestPostsImages)
                    @foreach ($latestPostsImages as $post)
                        <a href="{{ route('news.show', $post->slug) }}" class="footer_img_post_6">
                            <img src="{{ $post->image ? Storage::url($post->image) : asset('site/images/download.jpg') }}"
                                alt="{{ $post->title }}"
                                onerror="this.onerror=null;this.src='{{ asset('site/images/download.jpg') }}';" />
                        </a>
                    @endforeach
                @endisset
            </div>
        </div>
        <div class="row justify-content-center pt-2 pb-4">
            <div class="col-12 col-md-8 col-lg-7 ">
                <form action="{{ route('subscribe') }}" method="post">
                    @csrf
                    <div class="input-group">
                        <span class="input-group-addon fh5co_footer_text_box" id="basic-addon1"><i
                                class="fa fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control fh5co_footer_text_box"
                            placeholder="Nhập email của bạn..." aria-describedby="basic-addon1" required>
                        <button class="input-group-addon fh5co_footer_subcribe" id="basic-addon12" type="submit">
                            <i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Đăng ký
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <div class="container-fluid fh5co_footer_right_reserved">
    <div class="container">
        <div class="row  ">
            <div class="col-12 col-md-6 py-4 Reserved"> © Bản quyền 2018, Mọi quyền được bảo lưu. Thiết kế bởi <a
                    href="https://freehtml5.co" title="Free HTML5 Bootstrap templates">FreeHTML5.co</a>. </div>
            <div class="col-12 col-md-6 spdp_right py-4">
                <a href="#" class="footer_last_part_menu">Trang chủ</a>
                <a href="Contact_us.html" class="footer_last_part_menu">Giới thiệu</a>
                <a href="Contact_us.html" class="footer_last_part_menu">Liên hệ</a>
                <a href="blog.html" class="footer_last_part_menu">Tin mới nhất</a>
            </div>
        </div>
    </div>
</div> -->