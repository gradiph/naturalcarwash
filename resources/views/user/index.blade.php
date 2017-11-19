@extends('layouts.app')

@section('title') Pengguna | @endsection

@section('style')

@endsection

@section('nav')
	@if(Auth::user()->level->name == 'Admin')
		@include('layouts.nav.admin')
	@else
		@include('layouts.nav.cashier')
	@endif
@endsection

@section('header')
@endsection

@section('main')
<section id="user-title" class="mt-3">
	<div class="container">
		<h1>Kelola Data Pengguna</h1>
	</div>
</section>

<section id="user-alert" class="mt-3">
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

<section id="user-filter" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-5">
				<div class="input-group">
					<input type="text" autofocus value="{{ session('user_search') }}" id="search" class="form-control" placeholder="Cari Nama">
					<div class="input-group-btn">
						<button id="search-btn" class="btn btn-primary" type="button" title="Klik: Terapkan Pencarian">
							<span class="fa fa-search"></span>
						</button>
					</div>
					<div class="input-group-btn">
						<button id="refresh-btn" class="btn btn-warning" type="button" title="Klik: Reset Pencarian">
							<span class="fa fa-refresh"></span>
						</button>
					</div>
				</div>
			</div>
			<div class="col">
				<button id="deleted-btn" class="btn btn-info btn-block {{ session('user_deleted') == '0' ? '' : 'active' }}" type="button" data-deleted="{{ session('user_deleted') }}" title="{{ session('user_deleted') == '0' ? 'Klik: Tampilkan Semua Tarif' : 'Klik: Tampilkan Tarif Aktif' }}">
					<span class="fa {{ session('user_deleted') == '0' ? 'fa-folder' : 'fa-folder-open' }}"></span>
					<span id="deleted-text">{{ session('user_deleted') == '0' ? 'Pengguna Aktif' : 'Semua Pengguna' }}</span>
				</button>
			</div>
			<div class="col">
				<a id="new-btn" class="btn btn-success btn-block" href="{{ route('users.create') }}">
					<span class="fa fa-plus"></span> Pengguna Baru
				</a>
			</div>
		</div>
	</article>
</section>

<section id="user-list" class="mt-3">
	<article class="container" id="data"></article>
</section>

<section id="user-modal">
	<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
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
	ajaxLoad('{{ route('users.list') }}', 'data');

	$("#search").on('keyup', function(e) {
		if(e.keyCode == 13) {
			ajaxLoad('{{ route('users.list') }}?oksearch=1&search=' + $(this).val(), 'data');
		}
	});

	$("#search-btn").on('click', function(e) {
		$("#search").focus();
		ajaxLoad('{{ route('users.list') }}?oksearch=1&search=' + $("#search").val(), 'data');
	});

	$("#refresh-btn").on('click', function(e) {
		$("#search").val('').focus();
		ajaxLoad('{{ route('users.list') }}?oksearch=1&search=', 'data');
	});

	$("#deleted-btn").on('click', function(e) {
		if($(this).data('deleted') == '0') {
			ajaxLoad('{{ route('users.list') }}?deleted=1', 'data');
			$(this).addClass('active').data('deleted', '1').attr('title', 'Klik: Tampilkan Tarif Aktif');
			$(this).find('span.fa').removeClass('fa-folder').addClass('fa-folder-open');
			$(this).find('#deleted-text').html('Semua Pengguna');
		}
		else {
			ajaxLoad('{{ route('users.list') }}?deleted=0', 'data');
			$(this).removeClass('active').data('deleted', '0').attr('title', 'Klik: Tampilkan Semua Tarif');
			$(this).find('span.fa').removeClass('fa-folder-open').addClass('fa-folder');
			$(this).find('#deleted-text').html('Pengguna Aktif');
		}
	});

	$("#new-btn").on('click', function(e) {
		$(".loading").show();
	});
</script>
@endsection
