<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        @font-face {
            font-family: 'PT Sans Narrow';
            src: url({{ asset('fonts/pt_sans_narrow.ttf') }}) format('truetype');
        }

        @font-face {
            font-family: 'PT Sans';
            src: url({{ asset('fonts/pt_sans.ttf') }}) format('truetype');
        }
    </style>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <title>@yield('title') &mdash; PCForge</title>
</head>
<body class="light-bg">
@include('partials.header')
@yield('content')
@include('partials.footer')
@stack('scripts')
</body>
</html>
