<nav class="navbar navbar-expand-xl navbar-light bg-light">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}" style="font-variant: small-caps;">{{ config('app.name') }}</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item {{ Route::currentRouteName() == 'home.index' || Route::currentRouteName() == 'home.wash.add.beverage' ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('home.index') }}"><span class="fa fa-home fa-fw"></span> Beranda</a>
				</li>

				<li class="nav-item dropdown {{ Route::currentRouteName() == 'user-logs.index' || Route::currentRouteName() == 'reports.index' ? 'active' : '' }}">
					<a class="nav-link dropdown-toggle" href="#laporan" id="reportDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-newspaper-o fa-fw"></span> Laporan</a>
					<div class="dropdown-menu" aria-labelledby="reportDropdownMenuLink">
						<a class="dropdown-item" href="{{ route('user-logs.index') }}"><span class="fa fa-user fa-fw"></span> Aktivitas</a>

						<a class="dropdown-item" href="{{ route('reports.index') }}"><span class="fa fa-money fa-fw"></span> Keuangan</a>

						{{--
						<a class="dropdown-item" href="{{ route('expenditures.index') }}"><span class="fa fa-newspaper-o fa-fw" style="color: red;"></span> Pengeluaran</a>
						--}}
					</div>
				</li>

				{{--
				<li class="nav-item {{ Route::currentRouteName() == 'tools.index' || Route::currentRouteName() == 'tools.create' || Route::currentRouteName() == 'tools.edit' ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('tools.index') }}"><span class="fa fa-gavel fa-fw"></span> Peralatan</a>
				</li>
				--}}

				<li class="nav-item {{ Route::currentRouteName() == 'expenditures.index' || Route::currentRouteName() == 'expenditures.create' || Route::currentRouteName() == 'expenditures.edit' ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('expenditures.index') }}"><span class="fa fa-shopping-cart fa-fw"></span> Pengeluaran</a>
				</li>

				<li class="nav-item {{ Route::currentRouteName() == 'products.index' || Route::currentRouteName() == 'products.create' || Route::currentRouteName() == 'products.edit' ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('products.index') }}"><span class="fa fa-cubes fa-fw"></span> Minuman & Parfum</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#data-master" id="masterDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-info-circle fa-fw"></span> Data Master</a>
					<div class="dropdown-menu" aria-labelledby="masterDropdownMenuLink">
						<a class="dropdown-item" href="{{ route('mechanics.index') }}"><span class="fa fa-wrench fa-fw"></span> Mekanik</a>

						<a class="dropdown-item" href="{{ route('users.index') }}"><span class="fa fa-users fa-fw"></span> Pengguna</a>

						<a class="dropdown-item" href="{{ route('washing-rates.index') }}"><span class="fa fa-money fa-fw"></span> Tarif</a>
					</div>
				</li>
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item {{ Route::currentRouteName() == 'docs' ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('docs') }}"><span class="fa fa-book fa-fw"></span> Dokumentasi</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#{{ Auth::user()->name }}" id="authDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-user-circle fa-fw"></span> {{ Auth::user()->name }}</a>
					<div class="dropdown-menu" aria-labelledby="authDropdownMenuLink">
						<a class="dropdown-item" href="{{ route('password.change') }}"><span class="fa fa-lock fa-fw"></span> Ubah Password</a>

						<a class="btn dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); $('.loading').show(); $('#logoutForm').submit()"><span class="fa fa-sign-out fa-fw"></span> Keluar</a>
						<form id="logoutForm" action="{{ route('logout') }}" method="post" hidden>
							{{ csrf_field() }}
						</form>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
