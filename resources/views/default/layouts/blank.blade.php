<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="@yield('meta-charset', 'utf-8')">
    @if(getSetting('indexing'))
        <meta name="robots" content="index,follow">
    @else
        <meta name="robots" content="noindex,nofollow">
    @endif
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="@yield('meta-viewport', 'width=device-width, initial-scale=1')">
    <meta name="description" content="@yield('meta-description', '')">
    <meta name="keywords" content="@yield('meta-keywords', '')">
    <link rel="icon" type="image/x-icon" href="@yield('favicon', '/favicon.ico')">

    <title>@yield('title', 'Page Uz')</title>

    @stack('header')
</head>
<body @hasSection('body-class')class="@yield('body-class', '')" @endif
@hasSection('body-id')id="@yield('body-id', '')" @endif
>
@stack('top')

@yield('content')

@stack('footer')
</body>
</html>
