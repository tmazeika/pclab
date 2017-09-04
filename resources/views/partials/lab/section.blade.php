@php($typeName = $components->first()->parent->type->name)

<section class="lab-section">
    <h1 class="lab-section-header">{{ ucfirst($typeName) }}</h1>

    <div class="lab-section-content">
        @each('partials.lab.component', $components, 'component')
    </div>
</section>
