@extends('layouts.app')

@section('title') Ubah Password | @endsection

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
<section id="mechanic-form" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
				<div class="card">
					<div class="card-header">
						Ubah Password
					</div>
					<div class="card-body">
						@if(session('alert_messages'))
							<div class="alert {{ session('alert_type') }} alert-dismissible fade show" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								{{ session('alert_messages') }}
							</div>
						@endif
						<form action="{{ route('password.change') }}" method="post" id="changePasswordForm" role="form">
							{{ csrf_field() }}
							<div class="form-group row">
								<label for="inputoldpassword" class="col-6 col-form-label">Password Lama</label>
								<div class="col-6">
									<input type="password" id="inputoldpassword" name="oldpassword" class="form-control" required>
									@if(session('error_oldpassword'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ session('error_oldpassword', 'Test') }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputnewpassword" class="col-6 col-form-label">Password Baru</label>
								<div class="col-6">
									<input type="password" id="inputnewpassword" name="newpassword" class="form-control" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputnewpassword_confirmation" class="col-6 col-form-label">Konfirmasi Password Lama</label>
								<div class="col-6">
									<input type="password" id="inputnewpassword_confirmation" name="newpassword_confirmation" class="form-control" required>
									@if($errors->has('newpassword_confirmation'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('newpassword_confirmation')[0] }}</div>
									@endif
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer text-right">
						<button type="submit" id="submit-btn" form="changePasswordForm" class="btn btn-primary">
							<span class="fa fa-check"></span> Ubah
						</button>
						<button type="reset" id="reset-btn" form="changePasswordForm" class="btn btn-warning">
							<span class="fa fa-refresh"></span> Atur Ulang
						</button>
					</div>
				</div>
			</div>
		</div>
	</article>
</section>
@endsection

@section('footer')
@endsection

@section('script')
<script>
	$("#inputoldpassword").focus();
	@if($errors->has('newpassword_confirmation'))
		$("#inputnewpassword_confirmation").addClass('is-invalid');
	@endif

	@if(session('error_oldpassword'))
		$("#inputoldpassword").addClass('is-invalid');
	@endif

	$("#changePasswordForm").submit(function() {
		$("#submit-btn").attr('disabled', 'disabled');
		$(".loading").show();
	});

	$("#reset-btn").click(function() {
		$("#inputoldpassword").focus();
	});
</script>
@endsection
