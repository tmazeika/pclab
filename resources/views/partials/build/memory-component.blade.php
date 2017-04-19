<ul class="text">
    <li><span class="bold">Generation:</span> DDR{{ $component->ddr_gen }}</li>
    <li><span class="bold">Capacity:</span> {{ $component->capacity_each * $component->count }} GB</li>
    <li><span class="bold">Count:</span> {{ $component->count }}</li>
    <li><span class="bold">Pins:</span> {{ $component->pins }}</li>
</ul>
