@extends('layouts.app')

@section('title') Mekanik | @endsection

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
<section id="mechanic-title" class="mt-3">
	<div class="container">
		<h1>Kelola Data Mekanik</h1>
	</div>
</section>

<section id="mechanic-alert" class="mt-3">
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

<section id="mechanic-filter" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-5">
				<div class="input-group">
					<input type="text" autofocus value="{{ session('mechanic_search') }}" id="search" class="form-control" placeholder="Cari Nama">
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
			<div class="col">
				<button id="deleted-btn" class="btn btn-info btn-block {{ session('mechanic_deleted') == '0' ? '' : 'active' }}" type="button" data-deleted="{{ session('mechanic_deleted') }}">
					<span class="fa {{ session('mechanic_deleted') == '0' ? 'fa-folder' : 'fa-folder-open' }}"></span>
					<span id="deleted-text">{{ session('mechanic_deleted') == '0' ? 'Mekanik Aktif' : 'Semua Mekanik' }}</span>
				</button>
			</div>
			<div class="col">
				<a id="new-btn" class="btn btn-success btn-block" href="{{ route('mechanics.create') }}">
					<span class="fa fa-plus"></span> Mekanik Baru
				</a>
			</div>
		</div>
	</article>
</section>

<section id="mechanic-list" class="mt-3">
	<article class="container" id="data"></article>
</section>

<section id="mechanic-modal">
	<div class="modal fade" id="mechanicModal" tabindex="-1" role="dialog" aria-hidden="true">
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
	ajaxLoad('{{ route('mechanics.list') }}', 'data');

	$("#search").on('keyup', function(e) {
		if(e.keyCode == 13) {
			ajaxLoad('{{ route('mechanics.list') }}?oksearch=1&search=' + $(this).val(), 'data');
		}
	});

	$("#search-btn").on('click', function(e) {
		$("#search").focus();
		ajaxLoad('{{ route('mechanics.list') }}?oksearch=1&search=' + $("#search").val(), 'data');
	});

	$("#refresh-btn").on('click', function(e) {
		$("#search").val('').focus();
		ajaxLoad('{{ route('mechanics.list') }}?oksearch=1&search=', 'data');
	});

	$("#deleted-btn").on('click', function(e) {
		if($(this).data('deleted') == '0') {
			ajaxLoad('{{ route('mechanics.list') }}?deleted=1', 'data');
			$(this).addClass('active').data('deleted', '1');
			$(this).find('span.fa').removeClass('fa-folder').addClass('fa-folder-open');
			$(this).find('#deleted-text').html('Semua Mekanik');
		}
		else {
			ajaxLoad('{{ route('mechanics.list') }}?deleted=0', 'data');
			$(this).removeClass('active').data('deleted', '0');
			$(this).find('span.fa').removeClass('fa-folder-open').addClass('fa-folder');
			$(this).find('#deleted-text').html('Mekanik Aktif');
		}
	});

	$("#new-btn").on('click', function(e) {
		$(".loading").show();
	});
</script>
@endsection
