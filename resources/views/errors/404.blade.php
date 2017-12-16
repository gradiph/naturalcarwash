@extends('layouts.app')

@section('title') Kesalahan | @endsection

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
<section id="error" class="mt-3">
	<div class="jumbotron">
		<h1 class="display-3">Terjadi Kesalahan!</h1>
		<hr class="my-4">
		<p>{{ dd($exception->getMessages()) }}</p>
	</div>
</section>
@endsection

@section('footer')
@endsection
