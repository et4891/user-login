@extends('layouts.master')
@section('content')
	{{ Form::open(array('route' => 'account-change-password-post')) }}

	{{ Form::label('old_password', 'Old Password') }}
	{{ Form::password('old_password') }}
	@if($errors->has('old_password'))
		{{ $errors->first('old_password') }}
	@endif
	<br>

	{{ Form::label('new_password','New Password: ') }}
	{{ Form::password('new_password') }}
	@if($errors->has('new_password'))
		{{ $errors->first('new_password') }}
	@endif
	<br>

	{{ Form::label('confirm_password', 'Confirm Password') }}
	{{ Form::password('confirm_password') }}
	@if($errors->has('confirm_password'))
		{{ $errors->first('confirm_password') }}
	@endif
	<br>

	{{ Form::submit('Change Password') }}
	{{ Form::close() }}
@stop