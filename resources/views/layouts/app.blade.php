<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport"
		  content="width=device-width, initial-scale=1">

	{{-- Favicon --}}
	<link rel="icon"
		  href="/storage/img/Bulk Black Logo 800x600.png">

	<!-- CSRF Token -->
	<meta name="csrf-token"
		  content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Bulk Agencies') }}</title>

	<!-- Fonts -->
	<link rel="dns-prefetch"
		  href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito"
		  rel="stylesheet">

	<!-- Scripts -->
	<link href="{{ asset('css/app.css') }}"
		  rel="stylesheet">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet"
		  href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}"
		  rel="stylesheet">
	<link rel="stylesheet"
		  href="{{ asset('assets/libs/css/style.css') }}">
	<link rel="stylesheet"
		  href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
	<link rel="stylesheet"
		  href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">
	<link rel="stylesheet"
		  href="{{ asset('assets/vendor/charts/morris-bundle/morris.css') }}">
	<link rel="stylesheet"
		  href="{{ asset('assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
	<link rel="stylesheet"
		  href="{{ asset('assets/vendor/charts/c3charts/c3.css') }}">
	<link rel="stylesheet"
		  href="{{ asset('assets/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">

</head>

<body>
	@yield('login')

	<div class="dashboard-main-wrapper">

		@auth
		{{-- Top Nav --}}
		@include('layouts/topnav')

		{{-- Side Nav --}}
		@include('layouts/sidenav')
		@endauth

		<!-- wrapper  -->
		<div class="dashboard-wrapper">
			<div class="container-fluid  dashboard-content">

				@auth @include('layouts/page-header') @endauth

				<div class="row">
					<div class="col-sm-4"></div>
					<div class="col-sm-4">
						@include('core/messages')
					</div>
					<div class="col-sm-4"></div>
				</div>

				@yield('content')

			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}"
			defer></script>

	<!-- jquery 3.3.1 -->
	<script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
	<!-- bootstap bundle js -->
	<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
	<!-- slimscroll js -->
	<script src="{{ asset('assets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
	<!-- main js -->
	<script src="{{ asset('assets/libs/js/main-js.js') }}"></script>
	<!-- chart chartist js -->
	<script src="{{ asset('assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>
	<!-- sparkline js -->
	<script src="{{ asset('assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
	<!-- morris js -->
	<script src="{{ asset('assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/charts/morris-bundle/morris.js') }}"></script>
	<!-- chart c3 js -->
	<script src="{{ asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
	<script src="{{ asset('assets/libs/js/dashboard-ecommerce.js') }}"></script>
	{{-- Date Range Picker --}}
	<script src="{{ asset('assets/libs/js/date-range-picker.js') }}"></script>

	<!-- Include Required Prerequisites -->
	{{-- <script type="text/javascript"
			src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script> --}}
	<script type="text/javascript"
			src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	{{--
	<link rel="stylesheet"
		  type="text/css"
		  href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" /> --}}

	<!-- Include Date Range Picker -->
	<script type="text/javascript"
			src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<link rel="stylesheet"
		  type="text/css"
		  href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
</body>

</html>