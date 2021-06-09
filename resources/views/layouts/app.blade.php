<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

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

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/atlantis.min.css') }}">
	
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('css/demo.css') }}">
    <!-- Fonts -->
    
	<link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.dataTables.min.css') }}"/>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
        <div class="wrapper" id="app" data-user="{{Auth::user()? Auth::user()->id : null}}">
                @yield('content')
        </div>
	<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
        @yield('script')
    <!--   Core JS Files   -->
	<!-- <script src="{{ asset('js/core/jquery.3.2.1.min.js')}}"></script> -->
	<!-- <script src="{{ asset('js/core/bootstrap.min.js')}}"></script> -->
	<!-- <script src="{{ asset('js/core/popper.min.js')}}"></script> -->
	<!-- jQuery UI -->
	<script src="{{ asset('js/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('js/jquery.ui.touch-punch.min.js')}}"></script>
	<script src="{{ asset('js/datatables.min.js')}}"></script>
	<!-- jQuery Scrollbar -->
	<!-- <script type="text/javascript" src="{{ asset('js/tableExport.min.js') }}"></script> -->

	<script src="{{ asset('js/jquery.scrollbar.min.js')}}"></script>
	

	<!-- Chart JS -->
	<!-- <script src="{{ asset('js/plugin/chart.js/chart.min.js')}}"></script> -->

	<!-- jQuery Sparkline -->
	<script src="{{ asset('js/jquery.sparkline.min.js')}}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('js/circles.min.js')}}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('js/bootstrap-notify.min.js')}}"></script>

	<!-- jQuery Vector Maps -->
	<!-- <script src="{{ asset('js/plugin/jqvmap/jquery.vmap.min.js')}}"></script> -->
	<!-- <script src="{{ asset('js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script> -->

	<!-- Sweet Alert -->
	<script src="{{ asset('js/sweetalert.min.js')}}"></script>

	<!-- Atlantis JS -->
	

	<script src="{{ asset('js/atlantis.js')}}"></script>
	<script src="{{ asset('js/shcedule.js')}}"></script>
	<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('js/buttons.print.min.js') }}"></script>
	<script src="{{ asset('js/buttons.colVis.min.js') }}"></script>
	<script src="{{ asset('js/jszip.min.js') }}"></script>
	<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
	<!-- <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script> -->
	<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
	
    
</body>
</html>
