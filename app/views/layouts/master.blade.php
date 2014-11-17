<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ $title }}</title>
</head>
<body>
	@if(Session::has('global'))
		{{ Session::get('global') }}
	@endif
	@include('layouts.nav')
	@yield('content')
</body>
</html>