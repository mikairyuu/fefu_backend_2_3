<div>
    @auth
        <a href="{{ route('web_profile') }}">Profile</a>
        <a href="{{ route('web_logout') }}">Log out</a>
    @else
        <a href="{{ route('web_login') }}">Log in</a>
        <a href="{{ route('web_register') }}">Register</a>
    @endauth
</div>
