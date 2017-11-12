<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}" style="font-variant: small-caps;">{{ config('app.name') }}</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item {{ Route::currentRouteName() == 'washes.index' ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('home.index') }}"><span class="fa fa-home"></span> Beranda</a>
				</li>
				<li class="nav-item {{ Route::currentRouteName() == 'reports.index' ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('reports.index') }}"><span class="fa fa-newspaper-o"></span> Laporan</a>
				</li>
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#user" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="fa fa-user-circle"></span> {{ Auth::user()->name }}
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="{{ route('password.change') }}"><span class="fa fa-lock"></span> Ubah Password</a>

						<a class="btn dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); $('.loading').show(); $('#logoutForm').submit()"><span class="fa fa-sign-out"></span> Keluar</a>
						<form id="logoutForm" action="{{ route('logout') }}" method="post" hidden>
							{{ csrf_field() }}
						</form>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
