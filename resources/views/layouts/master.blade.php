<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata:400,700|Source+Sans+Pro:400">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <title>@yield('title') &mdash; PCLab</title>
</head>
<body>
    @include('partials.header')
    @yield('main')
    @include('partials.footer')
    @stack('scripts')
</body>
</html>
