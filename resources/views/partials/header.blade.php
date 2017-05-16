<header class="bar light-bg">
    <div class="content-container flex-container">
        <a href="{{ url('/') }}">@include('svg.logo')</a>
        <div class="flex-fill"></div>
        <a class="btn-link h4 @active(build)" href="{{ url('build') }}">BUILD</a>
    </div>
</header>
