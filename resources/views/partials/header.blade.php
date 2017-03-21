<header>
    <div class="content header-content">
        <a href="{{ url('/') }}">
            @include('svg.logo')
        </a>

        <div class="flex-spacer"></div>

        <a href="{{ url('build') }}">
            <button class="header-button">
                <img class="header-button-img" src="{{ url('img/wrench.svg') }}"/>
            </button>
        </a>
    </div>
</header>
