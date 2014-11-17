@extends('layouts.master')
@section('content')
	{{ Form::open(array('route' => 'account-forgot-password-post')) }}
	{{ Form::labeL('email', 'Email: ') }}
	{{ Form::text('email', '') }}
	@if($errors->has('email'))
		{{ $errors->first('email') }}
	@endif
	<br>
	{{ Form::submit('Password Reset') }}
	{{ Form::close() }}
@stop