@extends('layouts.app')

@section('title') Minuman & Parfum | @endsection

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
<section id="product-title" class="mt-3">
	<div class="container">
		<h1>Kelola Data Minuman & Parfum</h1>
	</div>
</section>

<section id="product-alert" class="mt-3">
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

<section id="product-filter" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-5">
				<div class="input-group">
					<input type="text" autofocus value="{{ session('product_search') }}" id="search" class="form-control" placeholder="Cari Nama">
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
				<select name="type" id="inputtype" class="form-control">
					<option value="">Filter Jenis</option>
					@foreach($types as $type)
						<option value="{{ $type->id }}" {{ session('product_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col">
				<button id="deleted-btn" class="btn btn-info btn-block {{ session('product_deleted') == '0' ? '' : 'active' }}" type="button" data-deleted="{{ session('product_deleted') }}">
					<span class="fa {{ session('product_deleted') == '0' ? 'fa-folder' : 'fa-folder-open' }}"></span>
					<span id="deleted-text">{{ session('product_deleted') == '0' ? 'Semua Minuman/Parfum' : 'Minuman/Parfum Aktif' }}</span>
				</button>
			</div>
			<div class="col">
				<a id="new-btn" class="btn btn-success btn-block" href="{{ route('products.create') }}">
					<span class="fa fa-plus"></span> Minuman/Parfum Baru
				</a>
			</div>
		</div>
	</article>
</section>

<section id="product-list" class="mt-3">
	<article class="container" id="data"></article>
</section>

<section id="product-modal">
	<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
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
	ajaxLoad('{{ route('products.list') }}', 'data');

	$("#inputtype").change(function() {
		ajaxLoad('{{ route('products.list') }}?oktype=1&type=' + $(this).val(), 'data');
	});

	$("#search").on('keyup', function(e) {
		if(e.keyCode == 13) {
			ajaxLoad('{{ route('products.list') }}?oksearch=1&search=' + $(this).val(), 'data');
		}
	});

	$("#search-btn").on('click', function(e) {
		$("#search").focus();
		ajaxLoad('{{ route('products.list') }}?oksearch=1&search=' + $("#search").val(), 'data');
	});

	$("#refresh-btn").on('click', function(e) {
		$("#search").val('').focus();
		ajaxLoad('{{ route('products.list') }}?oksearch=1&search=', 'data');
	});

	$("#deleted-btn").on('click', function(e) {
		if($(this).data('deleted') == '0') {
			ajaxLoad('{{ route('products.list') }}?deleted=1', 'data');
			$(this).addClass('active').data('deleted', '1');
			$(this).find('span.fa').removeClass('fa-folder').addClass('fa-folder-open');
			$(this).find('#deleted-text').html('Minuman/Parfum Aktif');
		}
		else {
			ajaxLoad('{{ route('products.list') }}?deleted=0', 'data');
			$(this).removeClass('active').data('deleted', '0');
			$(this).find('span.fa').removeClass('fa-folder-open').addClass('fa-folder');
			$(this).find('#deleted-text').html('Semua Minuman/Parfum');
		}
	});

	$("#new-btn").on('click', function(e) {
		$(".loading").show();
	});
</script>
@endsection
