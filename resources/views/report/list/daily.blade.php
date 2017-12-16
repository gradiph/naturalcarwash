@php(include_once(app_path().'/functions/indonesian_currency.php'))
<div class="row">
	<div class="col text-center">
		Total <a href="#income">Pemasukan</a> : <strong id="daily-income-total">0</strong>
	</div>
	<div class="col text-center">
		Total <a href="#expense">Pengeluaran</a> : <strong id="daily-expense-total">0</strong>
	</div>
	<div class="col text-center">
		Total Laba: <strong id="daily-profit-total">0</strong>
	</div>
	<div class="col-12 mt-3">
		@php
			$income_total = 0;
			$expense_total = 0;
		@endphp

		{{-- Success Transactions --}}
		<a name="income"><h4 class="">Pemasukan</h4></a>
		<table class="table table-responsive table-hover table-striped table-bordered text-center">
			<thead class="thead-inverse">
				<th class="text-center">NO</th>
				<th class="text-center">NO TRANSAKSI</th>
				<th class="text-center">JENIS TRANSAKSI</th>
				<th class="text-center">TOTAL CUCIAN</th>
				<th class="text-center">TOTAL NON-CUCIAN</th>
				<th class="text-center">SUBTOTAL</th>
			</thead>
			<tbody>
				@php
					$wash_total = 0;
					$nonwash_total = 0;
					//dd($success_transactions);
				@endphp
				@foreach($success_transactions as $transaction)
					@php
						$subtotal = $transaction->wash_total + $transaction->nonwash_total;
						$wash_total += $transaction->wash_total;
						$nonwash_total += $transaction->nonwash_total;
						$income_total += $subtotal;
					@endphp
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>#{{ $transaction->id }}</td>
						<td>{{ $transaction->type }}</td>
						<td>{{ indo_currency($transaction->wash_total) }}</td>
						<td>{{ indo_currency($transaction->nonwash_total) }}</td>
						<td>{{ indo_currency($subtotal) }}</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot class="table-primary">
				<th class="text-right" colspan="3">TOTAL</th>
				<th class="text-center">{{ indo_currency($wash_total) }}</th>
				<th class="text-center">{{ indo_currency($nonwash_total) }}</th>
				<th class="text-center">{{ indo_currency($income_total) }}</th>
			</tfoot>
		</table>

		{{-- Success Transactions --}}
		<h4 class="mt-5">Transaksi yang Dibatalkan</h4>
		<table class="table table-responsive table-hover table-striped table-bordered text-center">
			<thead class="thead-inverse">
				<th class="text-center">NO</th>
				<th class="text-center">NO TRANSAKSI</th>
				<th class="text-center">JENIS TRANSAKSI</th>
				<th class="text-center">ALASAN PEMBATALAN</th>
			</thead>
			<tbody>
				@foreach($canceled_transactions as $transaction)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>#{{ $transaction->id }}</td>
						<td>{{ $transaction->type }}</td>
						<td>{{ $transaction->cancel_reason }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		{{-- Expenditures --}}
		<a name="expense"><h4 class="mt-5">Pengeluaran</h4></a>
		<table class="table table-responsive table-hover table-striped table-bordered text-center">
			<thead class="thead-inverse">
				<th class="text-center">NO</th>
				<th class="text-center">NO PENGELUARAN</th>
				<th class="text-center">JENIS PENGELUARAN</th>
				<th class="text-center">KETERANGAN</th>
				<th class="text-center">HARGA</th>
			</thead>
			<tbody>
				@foreach($expenditures as $expenditure)
					@php
						$expense_total += $expenditure->price;
					@endphp
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>#{{ $expenditure->id }}</td>
						<td>{{ $expenditure->type->name }}</td>
						<td>{{ $expenditure->description }}</td>
						<td>{{ indo_currency($expenditure->price) }}</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot class="table-primary">
				<th class="text-right" colspan="4">TOTAL</th>
				<th class="text-center">{{ indo_currency($expense_total) }}</th>
			</tfoot>
		</table>
	</div>
</div>
<script>
	$(document).ready(function() {
		$("#daily-income-total").html('{{ indo_currency($income_total) }}');
		$("#daily-expense-total").html('{{ indo_currency($expense_total) }}');
		$("#daily-profit-total").html('{{ indo_currency($income_total - $expense_total) }}');
	});
</script>
