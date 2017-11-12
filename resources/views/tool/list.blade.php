@php include_once(app_path().'/functions/indonesian_currency.php'); @endphp
<div class="table-responsive">
	<table class="table table-hover table-bordered table-striped text-center">
		<thead class="thead-inverse">
			<th class="text-center">NO</th>
			<th class="text-center">NAMA</th>
			<th class="text-center">JUMLAH</th>
			<th class="text-center">KONDISI</th>
		</thead>
		<tbody>
			@php $i = ($tools->currentPage() - 1) * $tools->perpage(); @endphp
			@foreach($tools as $tool)
				<tr>
					<td>{{ ++$i }}</td>
					<td>
						<a class="btn-link" href="#show" data-link="{{ route('tools.show', ['tool' => $tool->id]) }}">
							{{ $tool->name }}
						</a>
					</td>
					<td>{{ indo_currency($tool->qty) }}</td>
					<td>{{ $tool->status }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div>
	<small>Catatan: Klik nama peralatan untuk melihat informasi lebih lengkap.</small>
</div>
<div class="row">
    <div class="col-4">
        Total data : {{ $tools->total() }}
    </div>
    <div class="col-8 text-right">
		{{ $tools->links() }}
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
		$("#toolModal").modal('show').find('.modal-content').empty().load($(this).data('link'), function() {
			$(".loading").hide();
		});
	});
</script>
