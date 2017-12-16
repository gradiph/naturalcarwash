@php(include_once(app_path().'/functions/indonesian_currency.php'))
@php(include_once(app_path().'/functions/indonesian_date.php'))
<div class="row">
	<div class="col text-center">
		Total Pemasukan : <strong id="monthly-income-total">0</strong>
	</div>
	<div class="col text-center">
		Total Pengeluaran : <strong id="monthly-expense-total">0</strong>
	</div>
	<div class="col text-center">
		Total Laba: <strong id="monthly-profit-total">0</strong>
	</div>
	<div class="col-12 mt-3">
		@php
			$income_total = 0;
			$expense_total = 0;
		@endphp
		<table class="table table-responsive table-hover table-striped table-bordered text-center">
			<thead class="thead-inverse">
				<th class="text-center">TANGGAL</th>
				<th class="text-center">TOTAL PEMASUKAN</th>
				<th class="text-center">TOTAL PENGELUARAN</th>
				<th class="text-center">SUBTOTAL</th>
			</thead>
			<tbody>
				@for($i = 0; $i < date('t', strtotime(session('report_monthly_month'))); $i++)
					@php
						$date = date('Y-m-d', strtotime(session('report_monthly_month') . ' + ' . $i . ' days'));
						$income_day_total = 0;
						$expense_day_total = 0;
						foreach($success_transactions as $transaction)
						{
							if(substr($transaction->creation_date, 0, 10) == $date)
							{
								$income_day_total += $transaction->wash_total + $transaction->nonwash_total;
							}
						}
						foreach($expenditures as $expenditure)
						{
							if(substr($expenditure->creation_date, 0, 10) == $date)
							{
								$expense_day_total += $expenditure->price;
							}
						}
						$subtotal = $income_day_total - $expense_day_total;
						$income_total += $income_day_total;
						$expense_total += $expense_day_total;
					@endphp
					<tr>
						<td>{{ indo_date($date) }}</td>
						<td>{{ indo_currency($income_day_total) }}</td>
						<td>{{ indo_currency($expense_day_total) }}</td>
						<td>{{ indo_currency($subtotal) }}</td>
					</tr>
				@endfor
			</tbody>
			<tfoot class="table-primary">
				<th class="text-right">TOTAL</th>
				<th class="text-center">{{ indo_currency($income_total) }}</th>
				<th class="text-center">{{ indo_currency($expense_total) }}</th>
				<th class="text-center">{{ indo_currency($income_total - $expense_total) }}</th>
			</tfoot>
		</table>
	</div>
</div>
<script>
	$(document).ready(function() {
		$("#monthly-income-total").html('{{ indo_currency($income_total) }}');
		$("#monthly-expense-total").html('{{ indo_currency($expense_total) }}');
		$("#monthly-profit-total").html('{{ indo_currency($income_total - $expense_total) }}');
	});
</script>
