<nav>
	<ul>
		@if (Auth::check())
			{{ Auth::user()->username }}, Thank you for coming back.
			<li><a href="{{ URL::route('user-profile', Auth::user()->username) }}">Profile</a></li>
			<li><a href="{{ URL::route('account-change-password') }}">Change Password</a></li>
			<li><a href="{{ URL::route('account-log-out') }}">Log Out</a></li>
		@else
			<li><a href="{{ URL::route('home') }}">Home</a></li>
			<li><a href="{{ URL::route('account-log-in') }}">Log In</a></li>
			<li><a href="{{ URL::route('account-register') }}">Register account</a></li>
			<li><a href="{{ URL::route('account-forgot-password') }}">Forgot Password</a></li>
		@endif

	</ul>
</nav>