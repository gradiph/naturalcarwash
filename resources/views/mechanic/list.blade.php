<div class="table-responsive">
	<table class="table table-hover table-bordered table-striped text-center">
		<thead class="thead-inverse">
			<th class="text-center">NO</th>
			<th class="text-center">NAMA</th>
			<th class="text-center">STATUS</th>
		</thead>
		<tbody>
			@php $i = ($mechanics->currentPage() - 1) * $mechanics->perpage(); @endphp
			@foreach($mechanics as $mechanic)
				<tr>
					<td>{{ ++$i }}</td>
					<td>
						<a class="btn-link" href="#show" data-link="{{ route('mechanics.show', ['mechanic' => $mechanic->id]) }}">
							{{ $mechanic->name }}
						</a>
					</td>
					<td>{{ $mechanic->deleted_at == null ? 'Aktif' : 'Nonaktif' }}</td>
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
        Total data : {{ $mechanics->total() }}
    </div>
    <div class="col-8 text-right">
		{{ $mechanics->links() }}
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
		$("#mechanicModal").modal('show').find('.modal-content').empty().load($(this).data('link'), function() {
			$(".loading").hide();
		});
	});
</script>
