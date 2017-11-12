@extends('layouts.app')

@section('title') Laporan Aktivitas | @endsection

@section('style')

@endsection

@section('nav')
	@if(Auth::user()->level == 'Admin')
		@include('layouts.nav.admin')
	@else
		@include('layouts.nav.cashier')
	@endif
@endsection

@section('header')
@endsection

@section('main')
<section id="user-log-title" class="mt-3">
	<div class="container">
		<h1>Laporan Aktivitas</h1>
	</div>
</section>

<section id="user-log-alert" class="mt-3">
	<div class="container">
		@if(session('alert_messages'))
			<div class="alert {{ session('alert_type') }} alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				{{ session('alert_messages') }}
			</div>
		@endif
	</div>
</section>

<section id="user-log-filter" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-5">
				<div class="input-group">
					<input type="text" autofocus value="{{ session('user_log_search') }}" id="search" class="form-control" placeholder="Cari Nama">
					<div class="input-group-btn">
						<button id="search-btn" class="btn btn-primary" type="button">
							<span class="fa fa-search"></span>
						</button>
					</div>
					<div class="input-group-btn">
						<button id="refresh-btn" class="btn btn-warning" type="button">
							<span class="fa fa-refresh"></span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</article>
</section>

<section id="user-log-list" class="mt-3">
	<article class="container" id="data"></article>
</section>

<section id="user-log-modal">
	<div class="modal fade" id="user-logModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content"></div>
		</div>
	</div>
</section>
@endsection

@section('footer')
@endsection

@section('script')
<script>
	ajaxLoad('{{ route('user-logs.list') }}', 'data');

	$("#search").on('keyup', function(e) {
		if(e.keyCode == 13) {
			ajaxLoad('{{ route('user-logs.list') }}?oksearch=1&search=' + $(this).val(), 'data');
		}
	});

	$("#search-btn").on('click', function(e) {
		$("#search").focus();
		ajaxLoad('{{ route('user-logs.list') }}?oksearch=1&search=' + $("#search").val(), 'data');
	});

	$("#refresh-btn").on('click', function(e) {
		$("#search").val('').focus();
		ajaxLoad('{{ route('user-logs.list') }}?oksearch=1&search=', 'data');
	});
</script>
@endsection
