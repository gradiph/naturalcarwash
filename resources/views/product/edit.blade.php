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
@php(include_once(app_path().'/functions/indonesian_currency.php'))
<section id="product-form" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
				<div class="card">
					<div class="card-header">
						Ubah {{ $product->name }}
					</div>
					<div class="card-body">
						<form action="{{ route('products.update', ['product' => $product->id]) }}" method="post" id="updateProductForm" role="form">
							{{ csrf_field() }}
							{{ method_field('put') }}
							<input type="hidden" name="id" value="{{ $product->id }}">
							<div class="form-group row">
								<label for="inputname" class="col-4 col-form-label">Nama</label>
								<div class="col-8">
									<input type="text" id="inputname" name="name" value="{{ old('name', $product->name) }}" class="form-control" required autocomplete="off">
									@if($errors->has('name'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('name')[0] }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputtype" class="col-4 col-form-label">Jenis</label>
								<div class="col-8">
									@foreach($types as $type)
										<div class="form-check">
											<label class="form-check-label">
												<input type="radio" class="form-check-input mt-3" name="type_id" value="{{ $type->id }}" {{ old('type_id', $product->type_id) == $type->id ? 'checked' : '' }}>
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
									<input type="text" id="inputprice" name="price" value="{{ old('price', indo_currency($product->price)) }}" class="form-control" required autocomplete="off">
									@if($errors->has('price'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('price')[0] }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputqty" class="col-4 col-form-label">Jumlah</label>
								<div class="col-8">
									<input type="text" id="inputqty" name="qty" value="{{ old('qty', $product->qty) }}" class="form-control" required autocomplete="off" {{ Auth::user()->level != 'Admin' ? 'readonly' : '' }}>
									@if($errors->has('qty'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('qty')[0] }}</div>
									@endif
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer text-right">
						<button type="submit" id="submit-btn" form="updateProductForm" class="btn btn-primary">
							<span class="fa fa-check"></span> Simpan
						</button>
						<a href="{{ route('products.index') }}" class="btn btn-danger">
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
	@elseif($errors->has('type'))
		$("#inputname").addClass('is-valid');
		$("#inputtype").focus().addClass('is-invalid');
	@elseif($errors->has('price'))
		$("#inputname").addClass('is-valid');
		$("#inputtype").addClass('is-valid');
		$("#inputprice").focus().addClass('is-invalid');
	@elseif($errors->has('qty'))
		$("#inputname").addClass('is-valid');
		$("#inputtype").addClass('is-valid');
		$("#inputprice").addClass('is-valid');
		$("#inputqty").focus().addClass('is-invalid');
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

	$("#inputqty").keyup(function(event) {
		$(this).val(auto_number(event, $(this).val()));
	});

	$("#updateProductForm").submit(function() {
		$("#inputprice").val($("#inputprice").val().replace(/\./g, ''));
		$("#inputqty").val($("#inputqty").val().replace(/\./g, ''));
		$("#submit-btn").attr('disabled', 'disabled');
		$(".loading").show();
	});
</script>
@endsection
