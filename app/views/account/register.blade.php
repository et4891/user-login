@extends('layouts.master')
@section('content')

	{{ Form::open(array('route' => 'account-register-post')) }}

	{{ Form::label('Email: ') }}
	{{ Form::text('email', '') }}
	@if($errors->has('email'))
		{{ $errors->first('email') }}
	@endif
	<br>

	{{ Form::label('Username: ') }}
	{{ Form::text('username', '') }}
	@if($errors->has('username'))
		{{ $errors->first('username') }}
	@endif
	<br>

	{{ Form::label('Password: ') }}
	{{ Form::password('password', '') }}
	@if($errors->has('password'))
		{{ $errors->first('password') }}
	@endif
	<br>

	{{ Form::label('Confirm Password: ') }}
	{{ Form::password('confirm_password', '') }}
	@if($errors->has('confirm_password'))
		{{ $errors->first('confirm_password') }}
	@endif
	<br>

	{{ Form::submit('Register')}}
	{{ Form::close() }}
@stop