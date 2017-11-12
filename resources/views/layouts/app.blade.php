<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>

		<title>@yield('title'){{ config('app.name', 'Laravel') }}</title>

		<link rel="shortcut icon" href="{{ asset('images/Logo - no bg.png') }}">

		<!-- Styles -->
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/bootstrap-grid.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/bootstrap-reboot.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		@yield('style')
	</head>
	<body>
		@yield('nav')

		<header>
			@yield('header')
		</header>

		<main>
			@yield('main')
		</main>

		<footer>
			@yield('footer')
		</footer>

		<div class="loading">
			<span class="fa fa-spinner fa-pulse fa-5x fa-fw"></span>
			<div class="text-center">Loading...</div>
		</div>

		@if(session()->has('modal_messages'))
			<div class="modal" id="alertModal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Messsages</h4>
						</div>
						<div class="modal-body">
							<p>{{ session('modal_messages') }}</p>
						</div>
					</div>
				</div>
			</div>
		@endif

		<!-- Scripts -->
		<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
		<script src="{{ asset('js/popper.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/app.min.js') }}"></script>
		@yield('script')
	</body>
</html>
