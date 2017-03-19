<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- favicon -->
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}" sizes="180x180">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('favicon-16x16.png') }}" sizes="16x16">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    <style>
        @font-face {
            font-family: Ravenscroft;
            src: url({{ asset('fonts/ravenscroft.ttf') }}) format('truetype');
        }

        @font-face {
            font-family: Source Sans Pro;
            src: url({{ asset('fonts/source-sans-pro.ttf') }}) format('truetype');
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <title>@yield('title') &mdash; PCForge</title>
</head>
<body>
    @include('partials.header')

    @yield('content')

    @include('partials.footer')
</body>
</html>
