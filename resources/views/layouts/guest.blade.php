<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page_title }}</title>
    <link rel="icon" href="{{ asset('site/images/logo.png') }}" type="image/x-icon">

    <!-- Kiểm tra đường dẫn asset -->
    <link href="{{ asset('site/css/media_query.css') }}" rel="stylesheet" type="text/css" />
    {{--
    <link href="{{ asset('site/css/bootstrap.css') }}" rel="stylesheet" type="text/css" /> --}} {{-- Removed old BS4 CSS
    --}}
    {{-- Added Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{ asset('site/css/animate.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:ital" rel="stylesheet">
    <link href="{{ asset('site/css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('site/css/owl.theme.default.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('site/css/style_1.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Modernizr JS -->
    <script src="{{ asset('site/js/modernizr-3.5.0.min.js') }}"></script>

    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->

</head>

<body>
    @include('client.blocks.header')
    @include('client.blocks.menu')
    @yield('content')

    @include('client.blocks.footer')
    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="fa fa-arrow-up"></i></a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> {{-- Keep jQuery for
    potential use in main.js --}}
    <script src="{{ asset('site/js/owl.carousel.min.js') }}"></script>

    {{-- Removed outdated Bootstrap 4 Alpha JS and Tether --}}
    {{--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
        crossorigin="anonymous"></script> --}}
    {{--
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
        crossorigin="anonymous"></script> --}}

    {{-- Added Bootstrap 5 Bundle (includes Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <!-- Waypoints -->
    <script src="{{ asset('site/js/jquery.waypoints.min.js') }}"></script>
    <!-- Parallax -->
    <script src="{{ asset('site/js/jquery.stellar.min.js') }}"></script>
    <!-- Main -->
    <script src="{{ asset('site/js/main.js') }}"></script>
    <script>if (!navigator.userAgent.match(/Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i)) { $(window).stellar(); }</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- Toastr Notification Script --}}
    <script>
        $(document).ready(function () {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000", // 5 seconds
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if(Session::has('success'))
                toastr.success("{{ Session::get('success') }}", "Success");
            @endif

            @if(Session::has('error'))
                toastr.error("{{ Session::get('error') }}", "Error");
            @endif

            @if(Session::has('info'))
                toastr.info("{{ Session::get('info') }}", "Info");
            @endif

            @if(Session::has('warning'))
                toastr.warning("{{ Session::get('warning') }}", "Warning");
            @endif

            // Display validation errors
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}", "Validation Error");
                @endforeach
            @endif
        });
    </script>
    {{-- Stack for page-specific scripts --}}
    @stack('scripts')
</body>

</html>