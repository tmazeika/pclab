@php($typeName = $components->first()->parent->type->name)

<section class="bar content-container">
    <header>
        <h3>{{ ucfirst($typeName) }}</h3>
    </header>

    <div class="content flex-container flex-grid">
        @each('partials.build.component', $components, 'component')
    </div>
</section>
