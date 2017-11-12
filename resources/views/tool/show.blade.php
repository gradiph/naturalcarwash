@php include_once(app_path().'/functions/indonesian_currency.php'); @endphp
<div class="modal-header">
	<h4 class="modal-title" id="modal-title">Peralatan <strong>{{ $tool->name }}</strong></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-12">
			<table class="mx-auto">
				<tr>
					<td class="align-top">Nama</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $tool->name }}</td>
				</tr>
				<tr>
					<td class="align-top">Jumlah</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ indo_currency($tool->qty) }}</td>
				</tr>
				<tr>
					<td class="align-top">Kondisi</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $tool->status }}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="modal-footer">
	<div class="col">
		<a href="{{ route('tools.edit', ['tool' => $tool->id]) }}" id="edit-btn" class="btn btn-warning btn-block">
			<span class="fa fa-pencil"></span> Ubah
		</a>
	</div>
	<div class="col">
		<button id="delete-btn" class="btn btn-danger btn-block">
			<span class="fa fa-times"></span> Hapus
		</button>
		<form id="deleteMechanicForm" action="{{ route('tools.destroy', ['tool' => $tool->id]) }}" method="post" hidden>
			{{ csrf_field() }}
			{{ method_field('delete') }}
		</form>
	</div>
</div>
<script>
	$("#modal").on('shown.bs.modal', function () {
		$(this).attr('aria-label', $("#modal-title").html());
	});

    $("#edit-btn").click(function(e) {
		$(".loading").show();
    });

	$("#delete-btn").click(function(e) {
		var d = confirm("Hapus?");
		if(d) {
			$(".loading").show();
			$("#deleteMechanicForm").submit();
		}
	});
</script>
