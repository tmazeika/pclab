<div class="component {{ $component->presenter()->selectedClass() }} {{ $component->presenter()->disabledClass() }}"
     data-component="{{ $component->parent->id }}"
     data-price="{{ $component->parent->price }}"
     data-count="{{ $component->presenter()->count() }}"
     data-allows-multiple="{{ $component->parent->type->is_allowed_multiple }}">
    <img src="{{ $component->parent->presenter()->img() }}" class="component-image"/>

    <header>
        <h3>{{ $component->parent->name }}</h3>
        <h4 class="dim">{{ $component->parent->presenter()->formattedPrice() }}</h4>
    </header>

    @include($component->featuresView())

    {{--@if($component->parent->type->is_allowed_multiple)--}}
        {{--<div>--}}
            {{--<button>&minus;</button>--}}
            {{--<span>{{ $component->presenter()->count() }}</span>--}}
            {{--<button>&plus;</button>--}}
        {{--</div>--}}
    {{--@endif--}}
</div>
