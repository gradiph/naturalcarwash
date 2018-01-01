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

<section id="docs-main" class="mt-3">
	<article class="container">
		<div class="row">
			<div id="docs-navigation" class="col-auto">
				<p><a href="#login">1. Login</a></p>
				<p><a href="#home">2. Beranda</a></p>
				<p><a href="#wash-transaction">2.1. Transaksi Cucian</a></p>
				<p><a href="#non-wash-transaction">2.1. Transaksi Non-Cucian</a></p>
				<p><a href="#product">3. Minuman dan Parfum</a></p>
				<p><a href="#create-product">3.1. Membuat Minuman atau Parfum Baru</a></p>
				<p><a href="#edit-product">3.2. Mengubah Minuman atau Parfum</a></p>
				<p><a href="#deactivate-product">3.3. Menon-aktifkan Minuman atau Parfum</a></p>
				<p><a href="#expenditure">4. Pengeluaran</a></p>
				<p><a href="#mechanic">5. Mekanik</a></p>
				<p><a href="#washing-rate">6. Tarif Cucian</a></p>
				<p><a href="#user">7. Pengguna</a></p>
				<p><a href="#report">8. Laporan</a></p>
				<p><a href="#change-password">9. Ubah Password</a></p>
			</div>
			<div class="col">
				<div id="div-login">
					<a name="login"><h1>Login</h1></a>
					<p>Ini Login</p>
					<figure class="figure">
						<a href="{{ asset('img/manuals/01 Login.JPG') }}" target="_blank">
							<img src="{{ asset('img/manuals/01 Login.JPG') }}" alt="01 Login.JPG" class="figure-img img-fluid border border-secondary">
						</a>
						<figcaption class="figure-caption text-center">Gambar 1 Login</figcaption>
					</figure>
				</div>
				<div id="div-home" class="mt-4">
					<a name="home"><h1>Beranda</h1></a>
					<p>Ini Beranda</p>
				</div>
				<div id="div-wash-transaction" class="mt-4">
					<a name="wash-transaction"><h1>Transaksi Cucian</h1></a>
					<p>Ini Transaksi Cucian</p>
				</div>
				<div id="div-non-wash-transaction" class="mt-4">
					<a name="non-wash-transaction"><h1>Transaksi Non-Cucian</h1></a>
					<p>Ini Transaksi Non-Cucian</p>
				</div>
				<div id="div-product" class="mt-4">
					<a name="product"><h1>Minuman dan Parfum</h1></a>
					<p>Ini Minuman dan Parfum</p>
				</div>
				<div id="div-create-product" class="mt-4">
					<a name="create-product"><h1>Membuat Minuman atau Parfum Baru</h1></a>
					<p>Ini Membuat Minuman atau Parfum Baru</p>
				</div>
				<div id="div-edit-product" class="mt-4">
					<a name="edit-product"><h1>Mengubah Minuman atau Parfum</h1></a>
					<p>Ini Mengubah Minuman atau Parfum</p>
				</div>
				<div id="div-deactivate-product" class="mt-4">
					<a name="deactivate-product"><h1>Menon-aktifkan Minuman atau Parfum</h1></a>
					<p>Ini Menon-aktifkan Minuman atau Parfum</p>
				</div>
			</div>
		</div>
	</article>
</section>
@endsection

@section('footer')
@endsection

@section('script')
@endsection
