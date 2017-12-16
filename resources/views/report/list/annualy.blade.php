@php(include_once(app_path().'/functions/indonesian_currency.php'))
@php(include_once(app_path().'/functions/indonesian_date.php'))
<div class="row">
	<div class="col text-center">
		Total Pemasukan : <strong id="annualy-income-total">0</strong>
	</div>
	<div class="col text-center">
		Total Pengeluaran : <strong id="annualy-expense-total">0</strong>
	</div>
	<div class="col text-center">
		Total Laba: <strong id="annualy-profit-total">0</strong>
	</div>
	<div class="col-12 mt-3">
		@php
			$income_total = 0;
			$expense_total = 0;
		@endphp
		<table class="table table-responsive table-hover table-striped table-bordered text-center">
			<thead class="thead-inverse">
				<th class="text-center">BULAN</th>
				<th class="text-center">TOTAL PEMASUKAN</th>
				<th class="text-center">TOTAL PENGELUARAN</th>
				<th class="text-center">SUBTOTAL</th>
			</thead>
			<tbody>
				@for($i = 0; $i < 12; $i++)
						@php
						$month = date('Y-m', strtotime(session('report_annualy_year') . '-01-01 + ' . $i . ' months'));
						$income_month_total = 0;
						$expense_month_total = 0;
						foreach($success_transactions as $transaction)
						{
							if(substr($transaction->creation_date, 0, 7) == $month)
							{
								$income_month_total += $transaction->wash_total + $transaction->nonwash_total;
							}
						}
						foreach($expenditures as $expenditure)
						{
							if(substr($expenditure->creation_date, 0, 7) == $month)
							{
								$expense_month_total += $expenditure->price;
							}
						}
						$subtotal = $income_month_total - $expense_month_total;
						$income_total += $income_month_total;
						$expense_total += $expense_month_total;
					@endphp
					<tr>
						<td>{{ indo_month($month) }}</td>
						<td>{{ indo_currency($income_month_total) }}</td>
						<td>{{ indo_currency($expense_month_total) }}</td>
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
		$("#annualy-income-total").html('{{ indo_currency($income_total) }}');
		$("#annualy-expense-total").html('{{ indo_currency($expense_total) }}');
		$("#annualy-profit-total").html('{{ indo_currency($income_total - $expense_total) }}');
	});
</script>
