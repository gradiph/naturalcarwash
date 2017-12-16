@php include_once(app_path().'/functions/indonesian_currency.php'); @endphp
<div class="modal-header">
	<h4 class="modal-title" id="modal-title"><strong>{{ $product->name }}</strong></h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-12">
			<table class="mx-auto">
				<tr>
					<td class="align-top">Nama</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $product->name }}</td>
				</tr>
				<tr>
					<td class="align-top">Jenis</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $product->type->name }}</td>
				</tr>
				<tr>
					<td class="align-top">Harga</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ indo_currency($product->price) }}</td>
				</tr>
				<tr>
					<td class="align-top">Jumlah</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ indo_currency($product->qty) }}</td>
				</tr>
				<tr>
					<td class="align-top">Status</td>
					<td class="align-top">&nbsp; : &nbsp;</td>
					<td class="align-top">{{ $product->trashed() ? 'Nonaktif' : 'Aktif' }}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="modal-footer">
	@if($product->trashed())
		<div class="col">
			<button id="restore-btn" class="btn btn-success btn-block">
				<span class="fa fa-product-plus"></span> Aktifkan Kembali
			</button>
			<form id="restoreProductForm" action="{{ route('products.restore', ['type' => session('product_type'), 'product' => $product->id]) }}" method="post" hidden>
				{{ csrf_field() }}
			</form>
		</div>
	@else
		<div class="col">
			<a href="{{ route('products.edit', ['product' => $product->id]) }}" id="edit-btn" class="btn btn-warning btn-block">
				<span class="fa fa-pencil"></span> Ubah
			</a>
		</div>
		<div class="col">
			<button id="add-btn" class="btn btn-success btn-block">
				<span class="fa fa-plus"></span> Tambah Stok
			</button>
			<form id="createProductForm" action="{{ route('products.store') }}" method="post" hidden>
				{{ csrf_field() }}
				<input type="hidden" id="inputid" name="id" value="{{ $product->id }}">
				<input type="hidden" id="inputqty" name="qty">
			</form>
		</div>
		<div class="col">
			<button id="delete-btn" class="btn btn-danger btn-block">
				<span class="fa fa-times"></span> Nonaktifkan
			</button>
			<form id="deleteProductForm" action="{{ route('products.destroy', ['type' => session('product_type'), 'product' => $product->id]) }}" method="post" hidden>
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
			$("#restoreProductForm").submit();
		}
	});

    $("#edit-btn").click(function(e) {
		$(".loading").show();
    });

	$("#delete-btn").click(function(e) {
		var d = confirm("Nonaktifkan?");
		if(d) {
			$(".loading").show();
			$("#deleteProductForm").submit();
		}
	});

	$("#add-btn").click(function(e) {
		var d = prompt("Tambah berapa buah?", "1");
		if(d > 0) {
			$(".loading").show();
			$("#inputqty").val(d);
			$("#createProductForm").submit();
		}
		else {
			alert('Jumlah salah');
		}
	});
</script>
