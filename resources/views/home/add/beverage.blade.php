@extends('layouts.app')

@section('title') Beranda: Tambah Minuman | @endsection

@section('style')

@endsection

@section('nav')
	@include('layouts.nav.cashier')
@endsection

@section('header')
@endsection

@section('main')
<section id="home-form" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
				<div class="card">
					<div class="card-header">
						Nomor Transaksi #{{ $transaction->id }}: Tambah Minuman
					</div>
					<div class="card-body">
						<form action="{{ route('home.wash.add.beverage', ['wash' => $wash->id]) }}" method="post" id="add-beverage-form" role="form">
							{{ csrf_field() }}
							<div class="form-group row">
								<label for="inputqty" class="col-4 col-form-label">Jumlah</label>
								<div class="col-8">
									<input type="text" id="inputqty" name="qty" value="{{ old('qty') }}" class="form-control" autocomplete="off" placeholder="1">
									@if($errors->has('qty'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('qty')[0] }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputname" class="col-4 col-form-label">Nama Minuman</label>
								<div class="col-8">
									<input type="text" id="inputname" name="name" value="{{ old('name') }}" class="form-control" autocomplete="off">
									@if($errors->has('product_id'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('product_id')[0] }}</div>
									@endif
									<div id="showProduct"></div>
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer text-right">
						<button type="submit" id="submit-btn" form="add-beverage-form" class="btn btn-primary">
							<span class="fa fa-check"></span> Simpan
						</button>
						<a href="{{ route('home.index') }}" class="btn btn-danger">
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
	ajaxLoad('{{ route('home.show.product') }}', 'showProduct');

	$("#inputqty").focus();
	@if($errors->has('qty'))
		$("#inputqty").focus().addClass('is-invalid');
	@elseif($errors->has('product_id'))
		$("#inputname").focus().addClass('is-invalid');
	@endif

	$("#inputname").keyup(function(e) {
		if ((e.keyCode >= 48 && e.keyCode <= 90) || e.keyCode == 8 || e.keyCode == 46) {
			console.log('{{ route('home.show.product') }}/' + $(this).val());
			if($(this).val() != '')
				ajaxLoad('{{ route('home.show.product') }}/' + $(this).val(), 'showProduct');
			else
				ajaxLoad('{{ route('home.show.product') }}', 'showProduct');
		}
	});

	$("#inputqty").keyup(function(e) {
		$(this).val(auto_number(e, $(this).val()));
	});

	$("#add-beverage-form").submit(function(e) {
		if($("#inputqty").val() == "") $("#inputqty").val('1');
		$("#submit-btn").attr('disabled', 'disabled');
		$(".loading").show();
	});
</script>
@endsection
