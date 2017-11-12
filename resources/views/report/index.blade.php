@extends('layouts.app')

@section('title') Laporan | @endsection

@section('style')

@endsection

@section('nav')
	@if(Auth::user()->level == 'Admin')
		@include('layouts.nav.admin')
	@else
		@include('layouts.nav.cashier')
	@endif
@endsection

@section('main')
@endsection

@section('footer')
@endsection

@section('script')
@endsection
