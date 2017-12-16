@extends('layouts.app')

@section('title') Kelola Pengeluaran | @endsection

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
<section id="expenditure-form" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
				<div class="card">
					<div class="card-header">
						Tambah Pengeluaran Baru
					</div>
					<div class="card-body">
						<form action="{{ route('expenditures.store') }}" method="post" id="createExpenditureForm" role="form">
							{{ csrf_field() }}
							<div class="form-group row">
								<label for="inputdate" class="col-4 col-form-label">Tanggal</label>
								<div class="col-8">
									<input type="date" id="inputdate" name="date" value="{{ old('date', date('Y-m-d')) }}" class="form-control" required {{ Auth::user()->level->name != 'Admin' ? 'readonly' : '' }} autocomplete="off">
									@if($errors->has('date'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('date')[0] }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputdescription" class="col-4 col-form-label">Keterangan</label>
								<div class="col-8">
									<textarea name="description" id="inputdescription" class="form-control" required autocomplete="off">{{ old('description') }}</textarea>
									@if($errors->has('description'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('description')[0] }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputtype" class="col-4 col-form-label">Jenis</label>
								<div class="col-8">
									@foreach($types as $type)
										<div class="form-check">
											<label class="form-check-label">
												<input type="radio" class="form-check-input mt-3" name="type_id" value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'checked' : '' }}>
												<input type="text" class="form-control-plaintext" readonly value="{{ $type->name }}">
											</label>
										</div>
									@endforeach
									<div class="form-check">
										<label class="form-check-label">
											<input type="radio" id="input-new-type" class="form-check-input mt-3" name="type_id" value="1" {{ (count($types) == 0 || old('type_id') == '0') ? 'checked' : '' }}>
											<input type="text" id="inputtype" name="type" value="{{ old('type') }}" class="form-control" autocomplete="off" {{ count($types) == 0 ? '' : 'disabled required' }}>
											@if($errors->has('type') || $errors->has('type_id'))
												<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get($errors->has('type') ? 'type' : 'type_id')[0] }}</div>
											@endif
										</label>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputprice" class="col-4 col-form-label">Harga</label>
								<div class="col-8">
									<input type="text" id="inputprice" name="price" value="{{ old('price') }}" class="form-control" autocomplete="off">
									@if($errors->has('price'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('price')[0] }}</div>
									@endif
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer text-right">
						<button type="submit" id="submit-btn" form="createExpenditureForm" class="btn btn-primary">
							<span class="fa fa-check"></span> Simpan
						</button>
						<a href="{{ route('expenditures.index') }}" class="btn btn-danger">
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
	$("#inputdescription").focus();
	@if($errors->has('description'))
		$("#inputdescription").focus().addClass('is-invalid');
	@elseif($errors->has('type') || $errors->has('type_id'))
		$("#inputdescription").addClass('is-valid');
		$("#inputtype").focus().addClass('is-invalid');
	@elseif($errors->has('price'))
		$("#inputdescription").addClass('is-valid');
		$("#inputtype").addClass('is-valid');
		$("#inputprice").focus().addClass('is-invalid');
	@endif

	$("input[type=radio][name=type_id]").on('change', function(e) {
		if($(this).val() == 1) {
			$("#inputtype").prop('disabled', false).prop('required', true).focus();
		}
		else {
			$("#inputtype").prop('disabled', true).prop('required', false);
		}
	});

	$("#inputprice").keyup(function(event) {
		$(this).val(auto_number(event, $(this).val()));
	});

	$("#createExpenditureForm").submit(function() {
		$("#submit-btn").attr('disabled', 'disabled');
		$("#inputprice").val($("#inputprice").val().replace(/\./g, ''));
		$(".loading").show();
	});
</script>
@endsection
