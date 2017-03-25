<ul class="build-chooser-item-features">
    <li><span class="bold">Form Factor:</span> {{ $component->formFactor->name }}</li>
    <li><span class="bold">Outputs:</span> {{ $component->outputsString() }}</li>
    <li><span class="bold">PCIe 3.0 Slots:</span> {{ $component->pcie3_slots }}</li>
    <li><span class="bold">SLI Support:</span> {{ $component->supports_sli ? 'Yes' : 'No' }}</li>
    <li><span class="bold">Max RAM Capacity:</span> {{ $component->dimm_max_capacity }} GB</li>
    <li><span class="bold">DIMM Generation:</span> DDR{{ $component->dimm_gen }}</li>
    <li><span class="bold">DIMM Pins:</span> {{ $component->dimm_pins }}</li>
    <li><span class="bold">DIMM Slots:</span> {{ $component->dimm_slots }}</li>
</ul>
