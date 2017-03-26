@php
    $components = $model::all();
    $type = (new $model)->type();
@endphp

<section class="build-section">
    <div class="build-header">
        <h1 class="build-heading">@lang("build.$type.title")</h1>
        <p class="build-desc">@lang("build.$type.desc")</p>
    </div>
    <div class="build-chooser">
        @foreach($components as $component)
        <div class="build-chooser-item">
            <img class="build-chooser-item-img" src="{{ $component->parent->img() }}"/>
            <h1 class="build-chooser-item-heading">
                {{ $component->parent->name }}
            </h1>
            <h1 class="build-chooser-item-heading build-chooser-item-price">
                {{ $component->parent->getPriceFormatted() }}
            </h1>
            @include($component->featuresView())
            <button class="build-chooser-item-button">Select</button>
        </div>
        @endforeach
    </div>
</section>
