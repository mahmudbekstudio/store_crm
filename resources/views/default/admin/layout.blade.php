<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="@yield('favicon', '/favicon.ico')">

    <title>@yield('title', 'Page Uz')</title>

    @stack('header')
</head>
<body>
@stack('top')

@yield('content')

@stack('footer')
</body>
</html>
