@php
	include_once(app_path().'/functions/indonesian_currency.php');
	include_once(app_path().'/functions/indonesian_date.php');
@endphp
<div class="modal-header">
	<h4 class="modal-title" id="modal-title">Pengeluaran Nomor #<strong>{{ $expenditure->id }}</strong></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-12">
			<table class="mx-auto">
				<tr>
					<td class="align-top">Tanggal</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ indo_date($expenditure->creation_date) }}</td>
				</tr>
				<tr>
					<td class="align-top">Jenis</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $expenditure->type->name }}</td>
				</tr>
				<tr>
					<td class="align-top">Nama Pengguna</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $expenditure->user->name }}</td>
				</tr>
				<tr>
					<td class="align-top">Deskripsi</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $expenditure->description }}</td>
				</tr>
				<tr>
					<td class="align-top">Harga</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ indo_currency($expenditure->price) }}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="modal-footer">
	@if(Auth::user()->level->name == 'Admin')
		<div class="col">
			<a href="{{ route('expenditures.edit', ['expenditure' => $expenditure->id]) }}" id="edit-btn" class="btn btn-warning btn-block">
				<span class="fa fa-pencil"></span> Ubah
			</a>
		</div>
		<div class="col">
			<button id="delete-btn" class="btn btn-danger btn-block">
				<span class="fa fa-trash"></span> Hapus
			</button>
			<form id="deleteExpenditureForm" action="{{ route('expenditures.destroy', ['type' => session('expenditure_type'), 'expenditure' => $expenditure->id]) }}" method="post" hidden>
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

    $("#edit-btn").click(function(e) {
		$(".loading").show();
    });

	$("#delete-btn").click(function(e) {
		var d = confirm("Hapus Pengeluaran?");
		if(d) {
			$(".loading").show();
			$("#deleteExpenditureForm").submit();
		}
	});
</script>
