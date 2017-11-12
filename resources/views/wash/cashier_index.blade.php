@extends('layouts.app')

@section('title') Cucian | @endsection

@section('style')

@endsection

@section('nav')
	@include('layouts.nav.cashier')
@endsection

@section('header')
@endsection

@section('main')
<section id="washing-panel" class="mt-3">
	<div class="container">
		<article id="wash-alert">
			@if(session('alert_messages'))
				<div class="alert {{ session('alert_type') }} alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					{{ session('alert_messages') }}
				</div>
			@endif
		</article>

		<article id="washing">
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="card">
						<div class="card-header">
							Transaksi Cucian
						</div>
						<div class="card-body">
							Tes
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card">
						<div class="card-header">
							Transaksi
						</div>
					</div>
				</div>
			</div>
		</article>
	</div>
</section>

<section id="wash-modal">
	<div class="modal fade" id="washModal" tabindex="-1" role="dialog" aria-hidden="true">
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

</script>
@endsection
