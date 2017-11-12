@php include_once(app_path().'/functions/indonesian_date.php'); @endphp
<div class="modal-header">
	<h4 class="modal-title" id="modal-title">Laporan Aktivitas #<strong>{{ $user_log->id }}</strong></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-12">
			<table class="mx-auto">
				<tr>
					<td class="align-top">Waktu</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ indo_date($user_log->creation_date) }}</td>
				</tr>
				<tr>
					<td class="align-top">Nama</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $user_log->user->name }}</td>
				</tr>
				<tr>
					<td class="align-top">Keterangan</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $user_log->description }}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<script>
	$("#modal").on('shown.bs.modal', function () {
		$(this).attr('aria-label', $("#modal-title").html());
	});
</script>
