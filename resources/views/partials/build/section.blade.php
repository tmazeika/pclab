@php($typeName = $components->first()->parent->type->name)

<section class="build-section">
    <div class="build-header">
        <h1 class="build-heading">@lang("build.$typeName.title")</h1>
        <p class="build-desc">@lang("build.$typeName.desc")</p>
    </div>
    <div class="build-chooser">
        @each('partials.build.component', $components, 'component')
    </div>
</section>
