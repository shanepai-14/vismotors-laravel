<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="{{ csrf_token() }}" name="csrf-token">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link href="https://fonts.bunny.net" rel="preconnect">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

	<!--favicon-->
	<link href="{{ asset('assets/images/favicon-32x32.png') }}" rel="icon" type="image/png" />
	<!--plugins-->
	<link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    @yield('additional_css')
	<!-- loader-->
	<link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link href="{{ asset('assets/css/dark-theme.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/semi-dark.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/header-colors.css') }}" rel="stylesheet" />
	<link rel="stylesheet" href="{{ asset('assets/js/dist/notiflix-3.2.7.min.css') }}"></link>
	<link  href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
	<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet"
/>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<link
rel="stylesheet"
href="https://print<script src="{{ asset('assets/js/pace.min.js') }}"></script>-4de6.kxcdn.com/print.min.css"
/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 @stack('styles')

	@vite([])
</head>

<body>
	<div class="bg-design"></div>
	<div class="wrapper">
		@include('layouts.shared.sidebar')
		@include('layouts.shared.header')
		<div class="page-wrapper">
			{{ $slot }}
		</div>
	</div>

	<!-- Bootstrap JS -->
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
	<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
	<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
	<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
	<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
	<script src='https://printjs-4de6.kxcdn.com/print.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @yield('additional_scripts')


	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="{{ asset('assets/js/dist/notiflix-3.2.7.min.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	@stack('scripts')
</body>

</html>
