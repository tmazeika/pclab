<div class="product {{ $component->presenter()->selectedClass() }} {{ $component->presenter()->disabledClass() }}"
     data-component="{{ $component->component_id }}"
     data-count="{{ $component->presenter()->count() }}"
     data-allows-multiple="{{ $component->parent->type->allows_multiple }}">
    <img src="{{ $component->parent->presenter()->img() }}"/>

    <header>
        <h5>{{ $component->parent->name }}</h5>
        <h5 class="dim">{{ $component->parent->presenter()->formattedPrice() }}</h5>
    </header>

    @include($component->featuresView())

    @if($component->parent->type->allows_multiple)
        <div>
            <button>&minus;</button>
            <span>{{ $component->presenter()->count() }}</span>
            <button>&plus;</button>
        </div>
    @endif
</div>
