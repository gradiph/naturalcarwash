<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}" style="font-variant: small-caps;">{{ config('app.name') }}</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item {{ Route::currentRouteName() == 'washes.index' ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('washes.index') }}"><span class="fa fa-shower fa-fw"></span> Cucian</a>
				</li>

				<li class="nav-item dropdown {{ Route::currentRouteName() == 'reports.index' ? 'active' : '' }}">
					<a class="nav-link dropdown-toggle" href="#laporan" id="reportDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-newspaper-o fa-fw"></span> Laporan</a>
					<div class="dropdown-menu" aria-labelledby="reportDropdownMenuLink">
						<a class="dropdown-item" href="{{ route('user-logs.index') }}"><span class="fa fa-newspaper-o fa-fw" style="color: gray;"></span> Aktivitas</a>

						<a class="dropdown-item" href="{{ route('user-logs.index') }}"><span class="fa fa-newspaper-o fa-fw" style="color: green;"></span> Pemasukan</a>

						<a class="dropdown-item" href="{{ route('expenditures.index') }}"><span class="fa fa-newspaper-o fa-fw" style="color: red;"></span> Pengeluaran</a>
					</div>
				</li>

				<li class="nav-item {{ Route::currentRouteName() == 'tools.index' || Route::currentRouteName() == 'tools.create' || Route::currentRouteName() == 'tools.edit' ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('tools.index') }}"><span class="fa fa-gavel fa-fw"></span> Peralatan</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#data-master" id="productDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-cubes fa-fw"></span> Stok</a>
					<div class="dropdown-menu" aria-labelledby="productDropdownMenuLink">
						<a class="dropdown-item" href="{{ route('products.index', ['type' => 'Minuman']) }}"><span class="fa fa-cube fa-fw" style="color: red;"></span> Minuman</a>

						<a class="dropdown-item" href="{{ route('products.index', ['type' => 'Parfum']) }}"><span class="fa fa-cube fa-fw" style="color: purple;"></span> Parfum</a>

						<a class="dropdown-item" href="{{ route('products.index', ['type' => 'Gelas Kopi']) }}"><span class="fa fa-cube fa-fw" style="color: brown;"></span> Gelas Kopi</a>
					</div>
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
