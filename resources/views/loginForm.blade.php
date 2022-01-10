<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *, :after, :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }
    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .bordered {
            border: 1px solid black;
        }

        .error {
            color: red;
        }
    </style>
    @include('includes.auth_header')
</head>
<body>
<h2>Login</h2>
@if($errors !== null)
    @foreach($errors->all() as $error)
        <p class="error">{{$error}}</p>
    @endforeach
@endif
<form method="POST" action="{{route('web_login')}}">
    @csrf
    <div>
        <label>Login</label>
        <label>
            <input class="bordered" name="login" type="text" value="{{$errors !== null ? old('login') : ''}}" size="20"/>
        </label>
    </div>
    <div>
        <label>Password</label>
        <label>
            <input class="bordered" name="password" type="password" value="" size="20"/>
        </label>
    </div>
    <input type="submit" value="Login">
</form>
<a href="{{route('oauth_redirect', ['driver' => 'github'])}}">Login through GitHub</a>
<a href="{{route('oauth_redirect', ['driver' => 'google'])}}">Login through Google</a>
</body>
</html>
