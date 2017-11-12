@php include_once(app_path().'/functions/indonesian_date.php'); @endphp
<div class="table-responsive">
	<table class="table table-hover table-bordered table-striped text-center">
		<thead class="thead-inverse">
			<th class="text-center">NO</th>
			<th class="text-center">WAKTU</th>
			<th class="text-center">NAMA</th>
			<th class="text-center">KETERANGAN</th>
		</thead>
		<tbody>
			@php $i = ($user_logs->currentPage() - 1) * $user_logs->perpage(); @endphp
			@foreach($user_logs as $user_log)
				<tr>
					<td>{{ ++$i }}</td>
					<td>
						<a class="btn-link" href="#show" data-link="{{ route('user-logs.show', ['user_log' => $user_log->id]) }}">
							{{ indo_date($user_log->creation_date) }}
						</a>
					</td>
					<td>{{ $user_log->user->name }}</td>
					<td>{{ $user_log->description }}</td>
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
        Total data : {{ $user_logs->total() }}
    </div>
    <div class="col-8 text-right">
		{{ $user_logs->links() }}
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
		$("#user-logModal").modal('show').find('.modal-content').empty().load($(this).data('link'), function() {
			$(".loading").hide();
		});
	});
</script>
