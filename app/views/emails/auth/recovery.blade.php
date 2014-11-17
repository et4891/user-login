Hello {{ $username }},
<br><br>
Please use the link below to recover your account and use the temporary password to log in.
<br><br>
-----
<br>
Temporary Password: {{ $password }}
<br>
<a href="{{ $link }}">{{ $link }}</a>
<br>
-----