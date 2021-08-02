<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset("css/fonts.min.css") }}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
    <!-- Scripts -->
    <!-- Sweet Alert -->
	<script src="{{ asset('js/sweetalert.min.js')}}"></script>
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('home/app.css') }}">
	<link rel="stylesheet" href="{{ asset('home/animate.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('home/paddle.css') }}">
</head>
<body class="flex flex-col min-h-screen bg-white pb-10">
        @yield('content')

        
        
        
        @yield('script')
        @include('home.footer')
</body>
</html>
