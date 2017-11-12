@extends('layouts.app')

@section('title') Beranda | @endsection

@section('style')
<style>
	.wash {
		font-weight: bold;
	}
</style>
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
				<div class="col-12 col-md-7">
					<div class="card mb-3">
						<div class="card-header">
							Transaksi Cucian
						</div>
						<div class="card-body">
							<div class="row">
								@foreach($washes as $wash)
									<div class="col-sm-6 mb-1">
										<div class="btn-group-vertical" role="group" aria-label="Cucian {{ $loop->iteration }}" style="width: 100%;">
											<button class="btn btn-lg btn-dark wash active" type="button">
												{{ $wash->description }}
											</button>
											<div class="btn-group" role="group" aria-label="Tombol Cucian {{ $loop->iteration }}">
												<button class="btn btn-lg btn-outline-info calculate-btn" type="button" data-link="{{ route('home.wash.calculate', ['wash' => $wash->id]) }}">
													<span class="fa fa-lg fa-calculator"></span>
												</button>
												<button class="btn btn-lg btn-outline-warning add-beverage-btn" type="button" data-link="{{ route('home.wash.add.beverage', ['wash' => $wash->id]) }}">
													<span class="fa fa-lg fa-beer"></span>
												</button>
												<button class="btn btn-lg btn-outline-success check-btn" type="button" data-action="{{ route('home.wash.check', ['wash' => $wash->id]) }}">
													<span class="fa fa-lg fa-check"></span>
												</button>
											</div>
										</div>
										<p></p>
									</div>
								@endforeach
								<form id="check-form" method="post">
									{{ csrf_field() }}
									{{ method_field('delete') }}
								</form>
								<div class="col-sm-6 mb-1">
									<a id="new-wash-btn" href="#new" class="btn btn-lg btn-primary wash" type="button">
										<p></p>
										<span class="fa fa-plus"></span> Baru
										<p></p>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card mb-3">
						<div class="card-header">
							Transaksi Non-Cucian
						</div>
						<div class="card-body">
							@if(count($errors->all()) > 0)
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									{{ $errors->first() }}
								</div>
							@endif
							<form id="add-beverage-form" role="form">
								{{ csrf_field() }}
								<div class="form-group row">
									<input type="hidden" id="inputtype" name="type" value="Umum" form="non-wash-transaction-form">
									<div class="col-6">
										<button id="umum-type-btn" class="btn btn-block btn-outline-info active" type="button">
											Umum
										</button>
									</div>
									<div class="col-6">
										<button id="karyawan-type-btn" class="btn btn-block btn-outline-info" type="button">
											Karyawan
										</button>
									</div>
								</div>
								<div id="worker-description" class="form-group row" hidden>
									<label for="inputdescription" class="col-4 col-form-label">Keterangan Karyawan</label>
									<div class="col-8">
										<input type="text" id="inputdescription" name="description" value="{{ old('description') }}" class="form-control" autocomplete="off" form="non-wash-transaction-form">
									</div>
								</div>
								<div class="form-group row">
									<label for="inputqty" class="col-4 col-form-label">Jumlah</label>
									<div class="col-8">
										<input type="text" id="inputqty" name="qty" value="{{ old('qty') }}" class="form-control" autocomplete="off" placeholder="1">
									</div>
								</div>
								<div class="form-group row">
									<label for="inputname" class="col-4 col-form-label">Nama Minuman</label>
									<div class="col-8">
										<input type="text" id="inputname" name="name" value="{{ old('name') }}" class="form-control" autocomplete="off">
										<div id="showProduct"></div>
									</div>
								</div>
								<button id="add-beverage-btn" class="btn btn-block btn-success" type="submit">
									<span class="fa fa-plus"></span> Tambah Minuman
								</button>
								<hr>
								<h3>
									Daftar Pesanan
									<small>
										(Total: Rp <span id="total">0</span>)
									</small>
								</h3>
								<ol id="productList">
									<span id="empty-productList">:: kosong ::</span>
								</ol>
							</form>
						</div>
						<div class="card-footer text-right">
							<form action="{{ route('home.non-wash-transaction') }}" id="non-wash-transaction-form" role="form" method="post">
								{{ csrf_field() }}
								<div id="products"></div>
							</form>
							<button type="submit" id="save-btn" class="btn btn-primary" form="non-wash-transaction-form">
								<span class="fa fa-check"></span> Simpan
							</button>
							<button id="reset-btn" class="btn btn-warning" type="reset" form="add-beverage-form">
								<span class="fa fa-refresh"></span> Atur Ulang
							</button>
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
	//Left Panel
	$("#new-wash-btn").click(function(e) {
		e.preventDefault();
		$(".loading").show();
		$("#washModal").modal('show').find(".modal-content").empty().load('{{ route('home.create.wash') }}', function() {
			$(".loading").hide();
		});
	});

	$(".calculate-btn").click(function(e) {
		$(".loading").show();
		$("#washModal").modal('show').find(".modal-content").empty().load($(this).data('link'), function() {
			$(".loading").hide();
		});
	});

	$(".add-beverage-btn").click(function(e) {
		$(".loading").show();
		window.location.href = $(this).data('link');
	});

	$(".check-btn").click(function(e) {
		var d = confirm("Selesai?");
		if(d) {
			$(".loading").show();
			$("#check-form").attr('action', $(this).data('action')).submit();
		}
		else {
			e.preventDefault();
		}
	});

	//Right Panel
	var total = 0;
	$("#inputqty").focus();
	ajaxLoad('{{ route('home.show.product') }}', 'showProduct');

	$("#umum-type-btn").click(function() {
		$(this).addClass('active');
		$("#karyawan-type-btn").removeClass('active');
		$("#inputtype").val('Umum');
		$("#worker-description").attr('hidden', 'hidden').find("#inputdescription").removeAttr('required');
		$("#inputqty").focus();
	});

	$("#karyawan-type-btn").click(function() {
		$(this).addClass('active');
		$("#umum-type-btn").removeClass('active');
		$("#inputtype").val('Karyawan');
		$("#worker-description").removeAttr('hidden').find("#inputdescription").attr('required', 'required');
		$("#inputdescription").focus();
	});

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
		e.preventDefault();
		var n = $("#inputqty").val() == "" ? 1 : parseInt($("#inputqty").val()),
			inputproduct_id = $("#inputproduct_id"),
			price = parseInt(inputproduct_id.data('price'));

		if(n <= parseInt(inputproduct_id.data('qty'))) {
			total += price * n;
			$("#empty-productList").hide();
			$("#productList").append(
				"<li>" +
				inputproduct_id.data('name') + " (" + price.toLocaleString() + ") &mdash; " + n +
				"</li>"
			);
			$("#products").append(
				"<input type='hidden' name='product_id[]' value='" + inputproduct_id.val() + "'>" +
				"<input type='hidden' name='qty[]' value='" + n + "'>"
			);
			$("#total").html(total.toLocaleString());
			$("#inputqty").val('').focus();
		}
		else {
			alert('Stok kurang');
			$("#inputqty").focus();
		}
	});

	$("#reset-btn").click(function(e) {
		total = 0;
		qty = [];
		product = [];
		ajaxLoad('{{ route('home.show.product') }}', 'showProduct');
		$("#total").html("0");
		$("#productList").empty();
		$("#products").empty();
		$("#inputqty").focus();
	});

	$("#non-wash-transaction-form").submit(function(e) {
		if(total == 0) {
			e.preventDefault();
			alert('Anda belum memilih minuman');
		}
		else {
			$(".loading").show();
			$("#save-btn").attr('disabled', 'disabled');
		}
	});
</script>
@endsection
