@extends('layouts.master')
@section('content')
{{ Auth::user()->username }}
<br>
{{ Auth::user()->email }}
@stop