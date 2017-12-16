@extends('layouts.app')

@section('title') Pengeluaran | @endsection

@section('style')

@endsection

@section('nav')
	@if(Auth::user()->level->name == 'Admin')
		@include('layouts.nav.admin')
	@elseif(Auth::user()->level->name == 'Kasir')
		@include('layouts.nav.cashier')
	@endif
@endsection

@section('header')
@endsection

@section('main')
<section id="expenditure-title" class="mt-3">
	<div class="container">
		<h1>{{ Auth::user()->level == 'Admin' ? 'Laporan' : 'Kelola Data' }} Pengeluaran</h1>
	</div>
</section>

<section id="expenditure-alert" class="mt-3">
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

<section id="expenditure-filter" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-5">
				<div class="input-group">
					<input type="text" autofocus value="{{ session('expenditure_search') }}" id="search" class="form-control" placeholder="Cari Nama atau Keterangan">
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
				<select id="inputtype" class="form-control">
					<option value="">Filter Jenis</option>
					@foreach($types as $type)
						<option value="{{ $type->id }}" {{ session('expenditure_text') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col">
				<a id="new-btn" class="btn btn-success btn-block" href="{{ route('expenditures.create') }}">
					<span class="fa fa-plus"></span> Pengeluaran Baru
				</a>
			</div>
		</div>
	</article>
</section>

<section id="expenditure-list" class="mt-3">
	<article class="container" id="data"></article>
</section>

<section id="expenditure-modal">
	<div class="modal fade" id="expenditureModal" tabindex="-1" role="dialog" aria-hidden="true">
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
	ajaxLoad('{{ route('expenditures.list') }}', 'data');

	$("#search").on('keyup', function(e) {
		if(e.keyCode == 13) {
			ajaxLoad('{{ route('expenditures.list') }}?oksearch=1&search=' + $(this).val(), 'data');
		}
	});

	$("#search-btn").on('click', function(e) {
		$("#search").focus();
		ajaxLoad('{{ route('expenditures.list') }}?oksearch=1&search=' + $("#search").val(), 'data');
	});

	$("#refresh-btn").on('click', function(e) {
		$("#search").val('').focus();
		ajaxLoad('{{ route('expenditures.list') }}?oksearch=1&search=', 'data');
	});

	$("#new-btn").on('click', function(e) {
		$(".loading").show();
	});
</script>
@endsection
