@extends('layouts.app')

@section('title') Pengguna | @endsection

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
<section id="user-form" class="mt-3">
	<article class="container">
		<div class="row">
			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
				<div class="card">
					<div class="card-header">
						Buat Pengguna Baru
					</div>
					<div class="card-body">
						<form action="{{ route('users.store') }}" method="post" id="createUserForm" role="form">
							{{ csrf_field() }}
							<div class="form-group row">
								<label for="inputname" class="col-4 col-form-label">Nama</label>
								<div class="col-8">
									<input type="text" id="inputname" name="name" value="{{ old('name') }}" class="form-control" required autocomplete="off">
									@if($errors->has('name'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('name')[0] }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputusername" class="col-4 col-form-label">Username</label>
								<div class="col-8">
									<input type="text" id="inputusername" name="username" value="{{ old('username') }}" class="form-control" required autocomplete="off">
									@if($errors->has('username'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('username')[0] }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputpassword" class="col-4 col-form-label">Password</label>
								<div class="col-8">
									<input type="password" id="inputpassword" name="password" class="form-control" required autocomplete="off">
									@if($errors->has('password'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('password')[0] }}</div>
									@endif
								</div>
							</div>
							<div class="form-group row">
								<label for="inputlevel_id" class="col-4 col-form-label">Jabatan</label>
								<div class="col-8">
								    @foreach($user_levels as $user_level)
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="level_id" value="{{ $user_level->id }}" {{ old('level_id') == $user_level->id ? 'checked' : '' }}>
                                                {{ $user_level->name }}
                                            </label>
                                        </div>
									@endforeach
									{{--
                                    <div class="row no-gutters">
									    <div class="col-auto">
									        <p class="form-control-plaintext">Jabatan Baru:&nbsp;</p>
									    </div>
									    <div class="col">
									        <input type="text" class="form-control" name="level_name">
									    </div>
									</div>
									--}}
									@if($errors->has('level_id'))
										<div class="invalid-feedback" style="font-size: 0.9em;">{{ $errors->get('level_id')[0] }}</div>
									@endif
								</div>
							</div>
						</form>
					</div>
					<div class="card-footer text-right">
						<button type="submit" id="submit-btn" form="createUserForm" class="btn btn-primary">
							<span class="fa fa-check"></span> Simpan
						</button>
						<a href="{{ route('users.index') }}" class="btn btn-danger">
							<span class="fa fa-times"></span> Batal
						</a>
					</div>
				</div>
			</div>
		</div>
	</article>
</section>
@endsection

@section('footer')
@endsection

@section('script')
<script>
	$("#inputname").focus();
	@if($errors->has('name'))
		$("#inputname").focus().addClass('is-invalid');
	@elseif($errors->has('username'))
		$("#inputname").addClass('is-valid');
		$("#inputusername").focus().addClass('is-invalid');
	@elseif($errors->has('level_id'))
		$("#inputname").addClass('is-valid');
		$("#inputusername").addClass('is-valid');
		$("#inputlevel_id").focus().addClass('is-invalid');
	@elseif($errors->has('password'))
		$("#inputname").addClass('is-valid');
		$("#inputusername").addClass('is-valid');
		$("#inputlevel_id").addClass('is-valid');
		$("#inputpassword").focus().addClass('is-invalid');
	@endif

	$("#createUserForm").submit(function() {
		$("#submit-btn").attr('disabled', 'disabled');
		$(".loading").show();
	});
</script>
@endsection
