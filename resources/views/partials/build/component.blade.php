<div class="build-chooser-item {{ $component->disabled ? 'disabled' : '' }} {{ $component->selected > 0 ? 'selected' : '' }}"
     data-component-id="{{ $component->component_id }}">
    <img class="build-chooser-item-img" src="{{ $component->parent->img() }}"/>
    <h1 class="build-chooser-item-heading">
        {{ $component->parent->name }}
    </h1>
    <h1 class="build-chooser-item-heading build-chooser-item-price">
        {{ $component->parent->getPriceFormatted() }}
    </h1>
    @include($component->featuresView())

    @if($component->parent->type->allows_multiple)
        <div class="build-chooser-item-quantity">
            <button class="build-chooser-item-quantity-button subtract">
                &minus;
            </button>
            <span class="build-chooser-item-quantity-text"></span>
            <button class="build-chooser-item-quantity-button add">
                &plus;
            </button>
        </div>
    @endif
</div>
