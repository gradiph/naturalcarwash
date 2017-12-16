<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/bootstrap-grid.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/bootstrap-reboot.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/tether.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/tether-theme-basic.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/tether-theme-arrows.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/tether-theme-arrows-dark.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style>
            html, body {
                background-color: #fff;
/*                font-family: 'Raleway', sans-serif;*/
                font-weight: bold;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
				font-weight: 100;
            }

			.subtitle {
				font-size: 16px;
				font-family: verdana;
			}

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    {{ config('app.name') }}<em class="subtitle">v1.0</em>
                </div>
                <div class="links">
                    <form action="{{ route('login') }}" method="post" id="loginForm" novalidate>
						@if(session('alert_messages'))
							<div class="alert {{ session('alert_type') }} alert-dismissible fade show" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								{!! session('alert_messages') !!}
							</div>
						@endif
                    	{{ csrf_field() }}
                    	<div class="form-group row">
							<label for="inputusername" class="col-form-label ml-auto col-3">Username</label>
                    		<div class="col-5 mr-auto">
                    			<input type="text" name="username" value="{{ old('username') }}" required autocomplete="off" id="inputusername" class="form-control {{ $errors->has('username') ? 'is-invalid' : (old('username') != '' ? 'is-valid' : '') }}" {{ $errors->has('username') ? 'autofocus' : (old('username') != '' ? '' : 'autofocus') }}>
                    			@if($errors->has('username'))
                    				<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('username')[0] }}</div>
                    			@endif
                    		</div>
                    	</div>
                    	<div class="form-group row">
                    		<label for="inputpassword" class="col-form-label ml-auto col-3">Password</label>
                    		<div class="col-5 mr-auto">
                    			<input type="password" name="password" required id="inputpassword" class="form-control {{ old('username') != '' && !$errors->has('username') ? 'is-invalid' : '' }}" {{ old('username') != '' && !$errors->has('username') ? 'autofocus' : '' }}>
                    			@if(old('username') != '' && !$errors->has('username'))
                    				<div class="invalid-feedback" style="font-size: 0.9em;">Password Salah</div>
                    			@endif
                    		</div>
                    	</div>
                    	<div class="form-group row">
                    		<div class="col-3 mx-auto">
                    			<button id="submit-btn" type="submit" class="btn btn-block btn-primary">
                    				<span class="fa fa-sign-in"></span> Masuk
                    			</button>
                    		</div>
                    	</div>
                    </form>
                </div>
            </div>
        </div>

        <div class="loading">
			<span class="fa fa-spinner fa-pulse fa-5x fa-fw"></span>
			<div class="text-center">Loading...</div>
		</div>

		<!-- Scripts -->
		<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
		<script src="{{ asset('js/tether.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
   		<script>
			$("#loginForm").submit(function() {
				$(".loading").show();
				$("#submit-btn").attr('disabled', 'disabled');
			});
		</script>
    </body>
</html>
