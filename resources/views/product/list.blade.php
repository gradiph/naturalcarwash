@php include_once(app_path().'/functions/indonesian_currency.php'); @endphp
<div class="table-responsive">
	<table class="table table-hover table-bordered table-striped text-center">
		<thead class="thead-inverse">
			<th class="text-center">NO</th>
			<th class="text-center">NAMA</th>
			<th class="text-center">JENIS</th>
			<th class="text-center">HARGA</th>
			<th class="text-center">JUMLAH</th>
			<th class="text-center">STATUS</th>
		</thead>
		<tbody>
			@php $i = ($products->currentPage() - 1) * $products->perpage(); @endphp
			@foreach($products as $product)
				<tr>
					<td>{{ ++$i }}</td>
					<td>
						<a class="btn-link" href="#show" data-link="{{ route('products.show', ['product' => $product->id]) }}">
							{{ $product->name }}
						</a>
					</td>
					<td>{{ $product->type->name }}</td>
					<td>{{ indo_currency($product->price) }}</td>
					<td>{{ indo_currency($product->qty) }}</td>
					<td>{{ $product->deleted_at == null ? 'Aktif' : 'Nonaktif' }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div>
	<small>Catatan: Klik nama minuman/parfum untuk melihat informasi lebih lengkap.</small>
</div>
<div class="row">
    <div class="col-4">
        Total data : {{ $products->total() }}
    </div>
    <div class="col-8 text-right">
		{{ $products->links() }}
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
		$("#productModal").modal('show').find('.modal-content').empty().load($(this).data('link'), function() {
			$(".loading").hide();
		});
	});
</script>
