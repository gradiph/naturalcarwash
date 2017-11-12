@php
	include_once(app_path().'/functions/indonesian_currency.php');
	include_once(app_path().'/functions/indonesian_date.php');
	$total = 0;
@endphp
<div class="modal-header">
	<h4 class="modal-title" id="modal-title">Nomor Transaksi #{{ $transaction->id }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-12">
			<table class="mx-auto">
				<tr>
					<td class="align-top">Tanggal</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ indo_date($transaction->creation_date) }}</td>
				</tr>
				<tr>
					<td class="align-top">Keterangan Kendaraan</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $wash->description }}</td>
				</tr>
				@if($transaction->description != null)
					<tr>
						<td class="align-top">Keterangan Karyawan</td>
						<td class="align-top">&nbsp; : &nbsp;</td>
						<td class="align-top">{{ $transaction->description }}</td>
					</tr>
				@endif
				@if($transaction->mechanics->count() > 0)
					<tr>
						<td class="align-top">Mekanik</td>
						<td class="align-top">&nbsp; : &nbsp;</td>
						<td class="align-top">
							<ol class="pl-3 mb-0">
								@foreach($transaction->mechanics as $mechanic)
									<li>
										{{ $mechanic->name }}
									</li>
								@endforeach
							</ol>
						</td>
					</tr>
				@endif
				<tr>
					<td class="align-top">Tarif</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">
						<ol class="pl-3 mb-0">
							@foreach($washing_rates as $washing_rate)
								@php($total += $washing_rate->price)
								<li>
									{{ $washing_rate->name }} (<strong>{{ indo_currency($washing_rate->price) }}</strong>)
								</li>
							@endforeach
						</ol>
					</td>
				</tr>
				@if($transaction->products->count() > 0)
					<tr>
						<td class="align-top">Minuman</td>
						<td class="align-top">&nbsp; : &nbsp;</td>
						<td class="align-top">
							<ol class="pl-3 mb-0">
								@foreach($transaction->products as $product)
									@php($subtotal = $product->pivot->qty * $product->pivot->price)
									@php($total += $subtotal)
									<li>
										{{ $product->name }} ({{ indo_currency($product->pivot->qty) }} &times; {{ indo_currency($product->pivot->price) }} = <strong>{{ indo_currency($subtotal) }}</strong>)
									</li>
								@endforeach
							</ol>
						</td>
					</tr>
				@endif
				<tr>
					<td class="align-top">Total</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">
						<strong><big>{{ indo_currency($total) }}</big></strong>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<form action="{{ route('home.wash.check', ['wash' => $wash->id]) }}" id="check-out-form" method="post">
		{{ csrf_field() }}
		{{ method_field('delete') }}
	</form>
</div>
<div class="modal-footer">
	<div class="col">
		<button id="check-out-btn" form="check-out-form" class="btn btn-block btn-success" type="submit">
			<span class="fa fa-check"></span> Selesai
		</button>
	</div>
	<div class="col">
		<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" aria-label="Close">
			<span class="fa fa-times"></span> Batal
		</button>
	</div>
</div>
<script>
	$("#check-out-btn").click(function(e) {
		var d = confirm("Selesai?");
		if(d) {
			$(".loading").show();
		}
		else {
			e.preventDefault();
		}
	});
</script>
