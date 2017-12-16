@extends('layouts.app')

@section('title') Dokumentasi | @endsection

@section('style')

@endsection

@section('nav')
	@if(Auth::user()->level->name == 'Admin')
		@include('layouts.nav.admin')
	@elseif(Auth::user()->level->name == 'Kasir')
		@include('layouts.nav.cashier')
	@endif
@endsection

@section('header')
@endsection

@section('main')
<section id="docs-title" class="mt-3">
	<div class="container">
		<h1>Dokumentasi</h1>
	</div>
</section>

<section id="docs-references" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-auto">
				<nav id="navbar-example3" class="navbar navbar-light bg-light">
					<nav class="nav nav-pills flex-column">
						<a class="nav-link" href="#item-1">Login</a>
						<a class="nav-link" href="#item-1">Beranda</a>
						<nav class="nav nav-pills flex-column">
							<a class="nav-link ml-3 my-1" href="#item-1-1">Item 1-1</a>
							<a class="nav-link ml-3 my-1" href="#item-1-2">Item 1-2</a>
						</nav>
						<a class="nav-link" href="#item-2">Minuman dan Parfum</a>
						<nav class="nav nav-pills flex-column">
							<a class="n1v-link ml-3 my-1" href="#item-3-1">Item 3-1</a>
							<a class="nav-link ml-3 my-1" href="#item-3-2">Item 3-2</a>
						</nav>
						<a class="nav-link" href="#item-3">Pengeluaran</a>
						<nav class="nav nav-pills flex-column">
							<a class="nav-link ml-3 my-1" href="#item-3-1">Item 3-1</a>
							<a class="nav-link ml-3 my-1" href="#item-3-2">Item 3-2</a>
						</nav>
					</nav>
				</nav>
			</div>
		</div>
	</article>
</section>
@endsection

@section('footer')
@endsection

@section('script')
@endsection
