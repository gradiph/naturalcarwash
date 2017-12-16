@extends('layouts.app')

@section('title') Minuman & Parfum | @endsection

@section('style')
<style>
	#data {
		border-right: 1px gray solid;
	}

	#data tbody tr {
		cursor: pointer;
	}

	@media screen and (max-width: 991px) {
		#data {
			border-right: 0;
			border-bottom: 1px gray solid;
		}
	}
</style>
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
			<div class="col-sm-10 col-md-8 mx-auto">
				<div class="card">
					<div class="card-header">
						Tambah Minuman/Parfum Baru
					</div>
					<div class="card-body">
						<form action="{{ route('products.store') }}" method="post" id="createProductForm" role="form">
							{{ csrf_field() }}
							<div class="row">
								<div id="data" class="col-12 col-lg-7 mb-3 mb-lg-0">
									<table class="table table-responsive table-hover text-center">
										<thead class="thead-inverse">
											<th class="text-center">NAMA</th>
											<th class="text-center">JENIS</th>
											<th class="text-center">HARGA</th>
											<th class="text-center">JUMLAH</th>
										</thead>
										@if(count($products) > 0)
											<tbody>
												@foreach($products as $product)
													<tr data-id="{{ $product->id }}"
														data-name="{{ $product->name }}"
														data-type_id="{{ $product->type_id }}"
														data-price="{{ indo_currency($product->price) }}">
														<td>{{ $product->name }}</td>
														<td>{{ $product->type->name }}</td>
														<td>{{ indo_currency($product->price) }}</td>
														<td>{{ indo_currency($product->qty) }}</td>
													</tr>
												@endforeach
											</tbody>
										@else
											<tfoot>
												<tr>
													<td colspan="3" class="text-center">..:: DATA KOSONG ::..</td>
												</tr>
											</tfoot>
										@endif
									</table>
									<input type="hidden" id="inputid" name="id">
								</div>
								<div class="col-12 col-lg-5">
									<div class="form-group row">
										<label for="inputname" class="col-4 col-form-label">Nama</label>
										<div class="col-8">
											<input type="text" id="inputname" name="name" value="{{ old('name') }}" class="form-control" autocomplete="off">
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
									<div class="form-group row">
										<label for="inputqty" class="col-4 col-form-label">Jumlah</label>
										<div class="col-8">
											<input type="text" id="inputqty" name="qty" value="{{ old('qty') }}" class="form-control" autocomplete="off">
											@if($errors->has('qty'))
												<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('qty')[0] }}</div>
											@endif
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer text-right">
						<button type="submit" id="submit-btn" form="createProductForm" class="btn btn-primary">
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
	@elseif($errors->has('type') || $errors->has('type_id'))
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

	$("#data tbody tr").click(function() {
		$("#inputid").val($(this).data('id'));
		$("#inputname").val($(this).data('name'));
		$("#inputprice").val($(this).data('price'));

		var type_id = $(this).data('type_id');
		$("input[type=radio][name=type_id]").each(function() {
			if($(this).val() == type_id) {
				$(this).prop('checked', true);
			}
			else {
				$(this).prop('checked', false);
			}
		});

		$("#inputname").change();
		$("#inputqty").focus();
	});

	$("#inputname").change(function() {
		$(".loading").show();
		$.get('{{ route('products.check.id') }}',
			{
				name: $(this).val()
			},
			function(data) {
				$("#inputid").val(data);
				$("#product-form .card-header").html(data != '' ? 'Tambah Stok Minuman/Parfum' : 'Tambah Minuman/Parfum Baru');
				$(".loading").hide();
			}
		);
	});

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

	$("#createProductForm").submit(function() {
		$("#inputprice").val($("#inputprice").val().replace(/\./g, ''));
		$("#inputqty").val($("#inputqty").val().replace(/\./g, ''));
		$("#submit-btn").attr('disabled', 'disabled');
		$(".loading").show();
	});
</script>
@endsection
