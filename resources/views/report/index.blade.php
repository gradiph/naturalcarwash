@extends('layouts.app')

@section('title') Laporan Keuangan | @endsection

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
<section id="report-title" class="mt-3">
	<div class="container">
		<h1>Laporan Keuangan</h1>
	</div>
</section>

<section id="report-alert" class="mt-3">
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

<section id="report-nav" class="mt-3">
	<article class="container">
		<ul id="tabs" class="nav nav-pills nav-fill" role="tablist">
			<li class="nav-item">
				<a id="daily-tab" class="nav-link{{ session('report_mode', 'daily') == 'daily' ? ' active' : '' }}" href="#daily" data-toggle="tab" role="tab" aria-controls="daily" aria-selected="{{ session('report_mode', 'daily') == 'daily' ? 'true' : 'false' }}">Harian</a>
			</li>
			<li class="nav-item">
				<a id="monthly-tab" class="nav-link{{ session('report_mode', 'daily') == 'monthly' ? ' active' : '' }}" href="#monthly" data-toggle="tab" role="tab" aria-controls="monthly" aria-selected="{{ session('report_mode', 'daily') == 'monthly' ? 'true' : 'false' }}">Bulanan</a>
			</li>
			<li class="nav-item">
				<a id="annualy-tab" class="nav-link{{ session('report_mode', 'daily') == 'annualy' ? ' active' : '' }}" href="#annual" data-toggle="tab" role="tab" aria-controls="annualy" aria-selected="{{ session('report_mode', 'daily') == 'annualy' ? 'true' : 'false' }}">Tahunan</a>
			</li>
			<li class="nav-item">
				<a id="custom-tab" class="nav-link{{ session('report_mode', 'daily') == 'custom' ? ' active' : '' }}" href="#custom" data-toggle="tab" role="tab" aria-controls="custom" aria-selected="{{ session('report_mode', 'daily') == 'custom' ? 'true' : 'false' }}">Jangka Tertentu</a>
			</li>
		</ul>
	</article>
</section>

<section id="report-tabs" class="mt-3">
	<article id="report-tab-content" class="tab-content container">
		<div id="daily" class="tab-pane fade{{ session('report_mode', 'daily') == 'daily' ? ' show active' : '' }}" role="tabpanel" aria-labelledby="daily-tab">
			<div class="row">
				<div class="col col-lg-4 mb-3">
					<input type="date" id="daily-inputdate" class="form-control btn-info" value="{{ session('report_daily_date', date('Y-m-d')) }}">
				</div>
				<div id="daily-data" class="col-12"></div>
			</div>
		</div>

		<div id="monthly" class="tab-pane fade{{ session('report_mode', 'daily') == 'monthly' ? ' show active' : '' }}" role="tabpanel" aria-labelledby="monthly-tab">
			<div class="row">
				<div class="col col-lg-4 mb-3">
					<input type="month" id="monthly-inputmonth" class="form-control btn-info" value="{{ session('report_monthly_month', date('Y-m')) }}">
				</div>
				<div id="monthly-data" class="col-12"></div>
			</div>
		</div>

		<div id="annual" class="tab-pane fade{{ session('report_mode', 'daily') == 'annualy' ? ' show active' : '' }}" role="tabpanel" aria-labelledby="annualy-tab">
			<div class="row">
				<div class="col col-lg-4 mb-3">
					<select id="annual-inputyear" class="form-control btn-info">
						@for($i = date('Y'); $i >= 2017; $i--)
							<option value="{{ $i }}">{{ $i }}</option>
						@endfor
					</select>
				</div>
				<div id="annualy-data" class="col-12"></div>
			</div>
		</div>

		<div id="custom" class="tab-pane fade{{ session('report_mode', 'daily') == 'custom' ? ' show active' : '' }}" role="tabpanel" aria-labelledby="custom-tab">
			<div class="row">
				<div class="col col-lg-3 mb-3">
					<input type="date" id="custom-inputdate1" class="form-control btn-info" value="{{ session('report_custom_date1', date('Y-m-d')) }}">
				</div>
				<div class="col col-lg-3">
					<input type="date" id="custom-inputdate2" class="form-control btn-info" value="{{ session('report_custom_date2', date('Y-m-d')) }}">
				</div>
				<div id="custom-data" class="col-12"></div>
			</div>
		</div>
	</article>
</section>

<section id="report-modal">
	<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-hidden="true">
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
	@if(session('report_mode', 'daily') == 'daily')
		ajaxLoad('{{ route('reports.list') }}?okmode=1&mode=daily', 'daily-data');
	@elseif(session('report_mode', 'daily') == 'monthly')
		ajaxLoad('{{ route('reports.list') }}?okmode=1&mode=monthly', 'monthly-data');
	@elseif(session('report_mode', 'daily') == 'annualy')
		ajaxLoad('{{ route('reports.list') }}?okmode=1&mode=annualy', 'annualy-data');
	@elseif(session('report_mode', 'daily') == 'custom')
		ajaxLoad('{{ route('reports.list') }}?okmode=1&mode=custom', 'custom-data');
	@endif

	$("#daily-tab").click(function(e) {
		ajaxLoad('{{ route('reports.list') }}?okmode=1&mode=daily', 'daily-data');
	});

	$("#daily-inputdate").change(function() {
		ajaxLoad('{{ route('reports.list') }}?okdate=1&date=' + $(this).val(), 'daily-data');
	});

	$("#monthly-tab").click(function(e) {
		ajaxLoad('{{ route('reports.list') }}?okmode=1&mode=monthly', 'monthly-data');
	});

	$("#monthly-inputmonth").change(function() {
		ajaxLoad('{{ route('reports.list') }}?okmonth=1&month=' + $(this).val(), 'monthly-data');
	});

	$("#annualy-tab").click(function(e) {
		ajaxLoad('{{ route('reports.list') }}?okmode=1&mode=annualy', 'annualy-data');
	});

	$("#annualy-inputyear").change(function() {
		ajaxLoad('{{ route('reports.list') }}?okyear=1&year=' + $(this).val(), 'annualy-data');
	});

	$("#custom-tab").click(function(e) {
		ajaxLoad('{{ route('reports.list') }}?okmode=1&mode=custom', 'custom-data');
	});

	$("#custom-inputdate1").change(function() {
		ajaxLoad('{{ route('reports.list') }}?okdate1=1&date1=' + $(this).val(), 'custom-data');
	});

	$("#custom-inputdate2").change(function() {
		ajaxLoad('{{ route('reports.list') }}?okdate2=1&date2=' + $(this).val(), 'custom-data');
	});
</script>
@endsection
