<div class="{{ $component->presenter()->selectedClass() }} {{ $component->presenter()->disabledClass() }}"
     data-component-id="{{ $component->component_id }}">
    <img class="build-chooser-item-img" src="{{ $component->parent->presenter()->img() }}" width="100px"/>
    <h5 class="build-chooser-item-heading">
        {{ $component->parent->name }}
    </h5>
    <h5 class="build-chooser-item-heading build-chooser-item-price">
        {{ $component->parent->presenter()->formattedPrice() }}
    </h5>
    @include('partials.build.' . $component::typeName() . '-component')

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
