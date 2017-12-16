@php include_once(app_path().'/functions/indonesian_date.php'); include_once(app_path().'/functions/indonesian_currency.php'); @endphp
<div class="table-responsive">
	<table class="table table-hover table-bordered table-striped text-center">
		<thead class="thead-inverse">
			<th class="text-center">NO</th>
			<th class="text-center">TANGGAL</th>
			<th class="text-center">JENIS</th>
			<th class="text-center">NAMA</th>
			<th class="text-center">KETERANGAN</th>
			<th class="text-center">HARGA</th>
		</thead>
		<tbody>
			@php $i = ($expenditures->currentPage() - 1) * $expenditures->perpage(); @endphp
			@foreach($expenditures as $expenditure)
				<tr>
					<td>{{ ++$i }}</td>
					<td>
						<a class="btn-link" href="#show" data-link="{{ route('expenditures.show', ['expenditure' => $expenditure->id]) }}">
							{{ indo_short_date($expenditure->creation_date) }}
						</a>
					</td>
					<td>{{ $expenditure->type->name }}</td>
					<td>{{ $expenditure->user->name }}</td>
					<td>{{ substr($expenditure->description, 0, 20) . ((strlen($expenditure->description) > 20) ? '...' : '') }}</td>
					<td>{{ indo_currency($expenditure->price) }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div>
	<small>Catatan: Klik tanggal untuk melihat informasi lebih lengkap.</small>
</div>
<div class="row">
    <div class="col-4">
        Total data : {{ $expenditures->total() }}
    </div>
    <div class="col-8 text-right">
		{{ $expenditures->links() }}
    </div>
</div>

<script>
    $('.pagination a').on('click', function (event) {
        event.preventDefault();
        ajaxLoad($(this).attr('href'), 'data');
    });

	$("a.btn-link").click(function(e) {
		e.preventDefault();
		$(".loading").show();
		$("#expenditureModal").modal('show').find('.modal-content').empty().load($(this).data('link'), function() {
			$(".loading").hide();
		});
	});
</script>
