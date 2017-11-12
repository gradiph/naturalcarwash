@php include_once(app_path().'/functions/indonesian_currency.php'); @endphp
<div class="table-responsive">
	<table class="table table-hover table-bordered table-striped text-center">
		<thead class="thead-inverse">
			<th class="text-center">NO</th>
			<th class="text-center">NAMA</th>
			<th class="text-center">HARGA</th>
			<th class="text-center">STATUS</th>
		</thead>
		<tbody>
			@php $i = ($washing_rates->currentPage() - 1) * $washing_rates->perpage(); @endphp
			@foreach($washing_rates as $washing_rate)
				<tr>
					<td>{{ ++$i }}</td>
					<td>
						<a class="btn-link" href="#show" data-link="{{ route('washing-rates.show', ['washing_rate' => $washing_rate->id]) }}">
							{{ $washing_rate->name }}
						</a>
					</td>
					<td>{{ indo_currency($washing_rate->price) }}</td>
					<td>{{ $washing_rate->deleted_at == null ? 'Aktif' : 'Nonaktif' }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div>
	<small>Catatan: Klik nama mekanik untuk melihat informasi lebih lengkap.</small>
</div>
<div class="row">
    <div class="col-4">
        Total data : {{ $washing_rates->total() }}
    </div>
    <div class="col-8 text-right">
		{{ $washing_rates->links() }}
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
		$("#washing_rateModal").modal('show').find('.modal-content').empty().load($(this).data('link'), function() {
			$(".loading").hide();
		});
	});
</script>
