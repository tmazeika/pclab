<section>
    <h1 class="lab-section-header">{{ ucfirst($components->first()->parent->type->name) }}</h1>

    <div class="lab-section">
        @each('partials.lab.component', $components, 'component')
    </div>
</section>
