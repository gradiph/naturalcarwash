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
        }
        #paper {
            display: block;
            width: 44mm;
            min-height: 48mm;
			background: yellow;
        }
		#header {
			text-align: center;
			font-size: 1.5em;
		}
		#title {
			border-bottom: 3px dashed black;
			padding: 3px;
		}
		#address {

		}
    </style>
</head>
<body>
    <div id="paper">
    	<div id="header">
    		<div id="title">NATURAL CAR WASH</div>
    		<div id="address">Jl. Beringin Raya No.173, Nusa Jaya, Karawaci, Kota </div>
    		<div id="city-phone">Tangerang &mdash; </div>
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
