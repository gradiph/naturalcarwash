@extends('layouts.app')

@section('title') {{ session('product_type') }} | @endsection

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
<section id="{{ $type }}-title" class="mt-3">
	<div class="container">
		<h1>Kelola Data {{ session('product_type') }}</h1>
	</div>
</section>

<section id="{{ $type }}-alert" class="mt-3">
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

<section id="{{ $type }}-filter" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-5">
				<div class="input-group">
					<input type="text" autofocus value="{{ session($type.'_search') }}" id="search" class="form-control" placeholder="Cari Nama">
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
				<button id="deleted-btn" class="btn btn-info btn-block {{ session($type.'_deleted') == '0' ? '' : 'active' }}" type="button" data-deleted="{{ session($type.'_deleted') }}">
					<span class="fa {{ session($type.'_deleted') == '0' ? 'fa-folder' : 'fa-folder-open' }}"></span>
					<span id="deleted-text">{{ session($type.'_deleted') == '0' ? session('product_type').' Aktif' : 'Semua '.session('product_type') }}</span>
				</button>
			</div>
			<div class="col">
				<a id="new-btn" class="btn btn-success btn-block" href="{{ route('products.create', ['type' => session('product_type')]) }}">
					<span class="fa fa-plus"></span> {{ session('product_type') }} Baru
				</a>
			</div>
		</div>
	</article>
</section>

<section id="{{ $type }}-list" class="mt-3">
	<article class="container" id="data"></article>
</section>

<section id="{{ $type }}-modal">
	<div class="modal fade" id="{{ $type }}Modal" tabindex="-1" role="dialog" aria-hidden="true">
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
	ajaxLoad('{{ route('products.list', ['type' => session('product_type')]) }}', 'data');

	$("#search").on('keyup', function(e) {
		if(e.keyCode == 13) {
			ajaxLoad('{{ route('products.list', ['type' => session('product_type')]) }}?oksearch=1&search=' + $(this).val(), 'data');
		}
	});

	$("#search-btn").on('click', function(e) {
		$("#search").focus();
		ajaxLoad('{{ route('products.list', ['type' => session('product_type')]) }}?oksearch=1&search=' + $("#search").val(), 'data');
	});

	$("#refresh-btn").on('click', function(e) {
		$("#search").val('').focus();
		ajaxLoad('{{ route('products.list', ['type' => session('product_type')]) }}?oksearch=1&search=', 'data');
	});

	$("#deleted-btn").on('click', function(e) {
		if($(this).data('deleted') == '0') {
			ajaxLoad('{{ route('products.list', ['type' => session('product_type')]) }}?deleted=1', 'data');
			$(this).addClass('active').data('deleted', '1');
			$(this).find('span.fa').removeClass('fa-folder').addClass('fa-folder-open');
			$(this).find('#deleted-text').html('Semua {{ session('product_type') }}');
		}
		else {
			ajaxLoad('{{ route('products.list', ['type' => session('product_type')]) }}?deleted=0', 'data');
			$(this).removeClass('active').data('deleted', '0');
			$(this).find('span.fa').removeClass('fa-folder-open').addClass('fa-folder');
			$(this).find('#deleted-text').html('{{ session('product_type') }} Aktif');
		}
	});

	$("#new-btn").on('click', function(e) {
		$(".loading").show();
	});
</script>
@endsection
