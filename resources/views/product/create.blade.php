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
<section id="{{ $type }}-form" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
				<div class="card">
					<div class="card-header">
						Buat {{ session('product_type') }} Baru
					</div>
					<div class="card-body">
						<form action="{{ route('products.store', ['type' => session('product_type')]) }}" method="post" id="createProductForm" role="form">
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
								<label for="inputprice" class="col-4 col-form-label">Harga</label>
								<div class="col-8">
									<input type="text" id="inputprice" name="price" value="{{ old('price') }}" class="form-control" required autocomplete="off">
									@if($errors->has('price'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('price')[0] }}</div>
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
						</form>
					</div>
					<div class="card-footer text-right">
						<button type="submit" id="submit-btn" form="createProductForm" class="btn btn-primary">
							<span class="fa fa-check"></span> Simpan
						</button>
						<a href="{{ route('products.index', ['type' => session('product_type')]) }}" class="btn btn-danger">
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
	@elseif($errors->has('price'))
		$("#inputname").addClass('is-valid');
		$("#inputprice").focus().addClass('is-invalid');
	@elseif($errors->has('qty'))
		$("#inputname").addClass('is-valid');
		$("#inputprice").addClass('is-valid');
		$("#inputqty").focus().addClass('is-invalid');
	@endif

	$("#inputprice").keyup(function(event) {
		$(this).val(auto_number(event, $(this).val()));
	});

	$("#inputqty").keyup(function(event) {
		$(this).val(auto_number(event, $(this).val()));
	});

	$("#createProductForm").submit(function() {
		$("#inputprice").val($("#inputprice").val().replace(/\./g, ''));
		$("#inputqty").val($("#inputqty").val().replace(/\./g, ''));
		$("#submit-btn").attr('disabled', 'disabled');
		$(".loading").show();
	});
</script>
@endsection
