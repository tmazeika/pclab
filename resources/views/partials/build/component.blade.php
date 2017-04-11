@php
    $components = $model::all();
    $typeName = $model::typeName();
    $tableName = $model::tableName();
@endphp

<section class="build-section">
    <div class="build-header">
        <h1 class="build-heading">@lang("build.$typeName.title")</h1>
        <p class="build-desc">@lang("build.$typeName.desc")</p>
    </div>
    <div class="build-chooser">
        @foreach($components as $component)
            @if($component->parent->is_available)
                <div class="build-chooser-item
                        {{ $component->parent->getSelectedCountInSession() > 0 ? 'selected' : '' }}
                        {{ $component->parent->isDisabledInSession() ? 'disabled' : '' }}"
                     data-component-id="{{ $component->parent->id }}">
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
            @endif
        @endforeach
    </div>
</section>
