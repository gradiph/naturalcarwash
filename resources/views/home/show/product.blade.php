@php(include_once(app_path().'/functions/indonesian_currency.php'))
<select name="product_id" id="inputproduct_id" class="form-control" size="4" required data-name="{{ $products[0]->name }}" data-price="{{ $products[0]->price }}" data-qty="{{ $products[0]->qty }}">
	@foreach($products as $product)
		<option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-qty="{{ $product->qty }}">{{ $product->name }} ({{ $product->type->name }}), {{ indo_currency($product->price) }}, sisa {{ indo_currency($product->qty) }}</option>
	@endforeach
</select>
<script>
	$("#inputproduct_id")[0].selectedIndex = 0;
	$("#inputproduct_id").change(function() {
		$(this).data('name', $(this).find(':selected').data('name'));
		$(this).data('price', $(this).find(':selected').data('price'));
		$(this).data('qty', $(this).find(':selected').data('qty'));
	});
</script>
