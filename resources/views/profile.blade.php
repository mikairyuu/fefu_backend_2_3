<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Profile</title>

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
<h2>Profile</h2>
<div>
    <label>Login:</label>
    <label>
        <b> {{$userData['login'] ?? 'None' }}</b>
    </label>
</div>
<div>
    <label>Name:</label>
    <label>
        <b> {{$userData['name']}}</b>
    </label>
</div>
<div>
    <label>Email:</label>
    <label>
        <b> {{$userData['email']}}</b>
    </label>
</div>
<div>
    <label>OAuth info:</label>
</div>
<div>
    <label>GitHub:</label>
    <label>
        <b> Last login date: {{$userData['github_login_date']?? 'None'}}</b>
        <b> Registration date: {{$userData['github_registration_date']?? 'None'}}</b>
    </label>
</div>
<div>
    <label>Google:</label>
    <label>
        <b> Last login date: {{$userData['google_login_date']?? 'None'}}</b>
        <b> Registration date: {{$userData['google_registration_date']?? 'None'}}</b>
    </label>
</div>
</body>
</html>
