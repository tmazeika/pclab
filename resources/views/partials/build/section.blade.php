@php($typeName = $components->first()->parent->type->name)

<section class="bar">
    <div class="bar-container">
        <header>
            <h4>@lang("build.$typeName.title")</h4>
            <p class="text">@lang("build.$typeName.desc")</p>
        </header>

        @each('partials.build.component', $components, 'component')
    </div>
</section>
