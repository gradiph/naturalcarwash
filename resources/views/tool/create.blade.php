@extends('layouts.app')

@section('title') Peralatan | @endsection

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
<section id="tool-form" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
				<div class="card">
					<div class="card-header">
						Buat Peralatan Baru
					</div>
					<div class="card-body">
						<form action="{{ route('tools.store') }}" method="post" id="createToolForm" role="form">
							{{ csrf_field() }}
							<div class="form-group row">
								<label for="inputname" class="col-4 col-form-label">Nama</label>
								<div class="col-8">
									<input type="text" id="inputname" name="name" value="{{ old('name') }}" class="form-control" required autocomplete="off">
									@if($errors->has('name'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('name')[0] }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputqty" class="col-4 col-form-label">Jumlah</label>
								<div class="col-8">
									<input type="text" id="inputqty" name="qty" value="{{ old('qty') }}" class="form-control" required autocomplete="off">
									@if($errors->has('qty'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('qty')[0] }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputstatus" class="col-4 col-form-label">Status</label>
								<div class="col-8">
									<select name="status" id="inputstatus" class="form-control" required>
										<option value="Bagus">Bagus</option>
										<option value="Jelek">Jelek</option>
										<option value="Rusak">Rusak</option>
									</select>
									@if($errors->has('status'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('status')[0] }}</div>
									@endif
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer text-right">
						<button type="submit" id="submit-btn" form="createToolForm" class="btn btn-primary">
							<span class="fa fa-check"></span> Simpan
						</button>
						<a href="{{ route('tools.index') }}" class="btn btn-danger">
							<span class="fa fa-times"></span> Batal
						</a>
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
	$("#inputname").focus();
	@if($errors->has('name'))
		$("#inputname").focus().addClass('is-invalid');
	@endif

	$("#inputqty").keyup(function(event) {
		$(this).val(auto_number(event, $(this).val()));
	});

	$("#createToolForm").submit(function() {
		$("#inputqty").val($("#inputqty").val().replace(/\./g, ''));
		$("#submit-btn").attr('disabled', 'disabled');
		$(".loading").show();
	});
</script>
@endsection
