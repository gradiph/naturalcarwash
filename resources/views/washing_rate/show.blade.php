@php include_once(app_path().'/functions/indonesian_currency.php'); @endphp
<div class="modal-header">
	<h4 class="modal-title" id="modal-title">Tarif <strong>{{ $washing_rate->name }}</strong></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-12">
			<table class="mx-auto">
				<tr>
					<td class="align-top">Nama</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $washing_rate->name }}</td>
				</tr>
				<tr>
					<td class="align-top">Harga</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ indo_currency($washing_rate->price) }}</td>
				</tr>
				<tr>
					<td class="align-top">Status</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $washing_rate->trashed() ? 'Nonaktif' : 'Aktif' }}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="modal-footer">
	@if($washing_rate->trashed())
		<div class="col">
			<button id="restore-btn" class="btn btn-success btn-block">
				<span class="fa fa-washing_rate-plus"></span> Aktifkan Kembali
			</button>
			<form id="restoreMechanicForm" action="{{ route('washing-rates.restore', ['washing_rate' => $washing_rate->id]) }}" method="post" hidden>
				{{ csrf_field() }}
			</form>
		</div>
	@else
		<div class="col">
			<a href="{{ route('washing-rates.edit', ['washing_rate' => $washing_rate->id]) }}" id="edit-btn" class="btn btn-warning btn-block">
				<span class="fa fa-pencil"></span> Ubah
			</a>
		</div>
		<div class="col">
			<button id="delete-btn" class="btn btn-danger btn-block">
				<span class="fa fa-times"></span> Nonaktifkan
			</button>
			<form id="deleteMechanicForm" action="{{ route('washing-rates.destroy', ['washing_rate' => $washing_rate->id]) }}" method="post" hidden>
				{{ csrf_field() }}
				{{ method_field('delete') }}
			</form>
		</div>
	@endif
</div>
<script>
	$("#modal").on('shown.bs.modal', function () {
		$(this).attr('aria-label', $("#modal-title").html());
	});

	$("#restore-btn").click(function(e) {
		var d = confirm("Aktifkan kembali?");
		if(d) {
			$(".loading").show();
			$("#restoreMechanicForm").submit();
		}
	});

    $("#edit-btn").click(function(e) {
		$(".loading").show();
    });

	$("#delete-btn").click(function(e) {
		var d = confirm("Nonaktifkan?");
		if(d) {
			$(".loading").show();
			$("#deleteMechanicForm").submit();
		}
	});
</script>
