@php(include_once(app_path().'/functions/indonesian_currency.php'))
@php($total = 0)
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
		@font-face {
			font-family: MyriadPro;
			src: url("{{ asset('fonts/MyriadPro-Semibold.otf') }}");
		}
        html, body {
            margin: 0;
            padding: 0;
            display: hidden;
            font-size: 10px;
            font-family: MyriadPro;
			font-weight: 500;
			line-height: 1;
        }
        #paper {
            display: block;
            width: 44mm;
            min-height: 48mm;
			background: yellow;
        }
		#border {
			border-top: 2px dashed black;
		}
		#header {
			text-align: center;
			padding-bottom: 6px;
		}
		#title {
			font-size: 14px;
			font-weight: bold;
			padding: 3px;
		}
		#body {
			padding-bottom: 6px;
		}
		#wash {
			margin-bottom: 6px;
		}
		.product-price {
			padding-left: 10px;
		}
		#total {
			border-top: 1px solid black;
			margin-top: 6px;
			padding-top: 6px;
			font-size: 12px;
			font-weight: 800;
		}
		#wash-title, #products-title {
			font-size: 11px;
		}
		.washing-rate-price, .price-total, .total-price {
			float: right;
		}
		#footer {
			text-align: center;
			font-size: 8px;
		}
    </style>
</head>
<body>
    <div id="paper">
    	<div id="header">
    		<div id="title">NATURAL CAR WASH</div>
    		<div id="address">Jl. Beringin Raya No.173, Nusa Jaya</div>
    		<div id="city-phone">Tangerang{{-- &mdash; Telp. (021)2022002--}}</div>
    	</div>
    	<div id="border">
    		&nbsp;
    	</div>
    	<div id="body">
    		@if(count($wash) > 0)
    			<div id="wash">
    				<div id="wash-title">
    					<u>Transaksi Cucian</u>
    				</div>
    				<div id="wash-list">
    					@foreach($wash->washingRates as $washing_rate)
    						<div class="washing-rate">
    							<span class="washing-rate-name">
    								{{ $loop->iteration }}. {{ $washing_rate->name }}
    							</span>
    							<span class="washing-rate-price">
    								@php($total += $washing_rate->pivot->price)
    								{{ indo_currency($washing_rate->pivot->price) }}
    							</span>
    						</div>
    					@endforeach
    				</div>
    			</div>
    		@endif
    		@if(count($products) > 0)
    			<div id="products">
    				<div id="products-title">
    					<u>Transaksi Non-Cucian</u>
    				</div>
    				<div id="products-list">
    					@foreach($products as $product)
    						<div class="product">
    							<div class="product-name">
    								{{ $loop->iteration }}. {{ $product->name }}
    							</div>
    							<div class="product-price">
    								<span class="price-detail">
    									{{ indo_currency($product->pivot->qty) }} &times; {{ indo_currency($product->pivot->price) }}
    								</span>
    								<span class="price-total">
    									@php($total += $product->pivot->qty * $product->pivot->price)
    									{{ indo_currency($product->pivot->qty * $product->pivot->price) }}
    								</span>
    							</div>
    						</div>
    					@endforeach
    				</div>
    			</div>
    		@endif
    		<div id="total">
    			<span class="total-title">
    				TOTAL
    			</span>
    			<span class="total-price">
    				{{ indo_currency($total) }}
    			</span>
    		</div>
    	</div>
    	<div id="border">
    		&nbsp;
    	</div>
    	<div id="footer">
    		&copy;NaturalCarWash 2017 &mdash; {{ date('d-m-Y H:i:s', strtotime($transaction->creation_date)) }}
    	</div>
    </div>
</body>
<script src="{{asset('/js/jquery-3.2.1.min.js')}}"></script>
<script>
    $(document).ready(function() {
//        window.print();
//        setTimeout(function() {
//			window.close();
//		}, 100);
    });
</script>
</html>
