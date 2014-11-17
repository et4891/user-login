@extends('layouts.master')
@section('content')
	{{ Form::open(array('route' => 'account-log-in-post')) }}

	{{ Form::label('Email: ') }}
	{{ Form::text('email', '') }}
	@if($errors->has('email'))
		{{ $errors->first('email') }}
	@endif
	<br>

	{{ Form::label('Password: ') }}
	{{ Form::password('password', '') }}
	@if($errors->has('password'))
		{{ $errors->first('password') }}
	@endif
	<br>

	{{ Form::label('remember', 'Remember me') }}
	{{ Form::checkbox('remember', 'remember') }}
	<br>
	{{ Form::submit('Log in') }}
	{{ Form::close() }}
@stop