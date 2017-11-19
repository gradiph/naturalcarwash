<div class="table-responsive">
	<table class="table table-hover table-bordered table-striped text-center">
		<thead class="thead-inverse">
			<th class="text-center">NO</th>
			<th class="text-center">NAMA</th>
			<th class="text-center">JABATAN</th>
			<th class="text-center">STATUS</th>
		</thead>
		<tbody>
			@php $i = ($users->currentPage() - 1) * $users->perpage(); @endphp
			@foreach($users as $user)
				<tr>
					<td>{{ ++$i }}</td>
					<td>
						<a class="btn-link" href="#show" data-link="{{ route('users.show', ['user' => $user->id]) }}">
							{{ $user->name }}
						</a>
					</td>
					<td>{{ $user->level->name }}</td>
					<td>{{ $user->deleted_at == null ? 'Aktif' : 'Nonaktif' }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div>
	<small>Catatan: Klik nama pengguna untuk melihat informasi lebih lengkap.</small>
</div>
<div class="row">
    <div class="col-4">
        Total data : {{ $users->total() }}
    </div>
    <div class="col-8 text-right">
		{{ $users->links() }}
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
		$("#userModal").modal('show').find('.modal-content').empty().load($(this).data('link'), function() {
			$(".loading").hide();
		});
	});
</script>
