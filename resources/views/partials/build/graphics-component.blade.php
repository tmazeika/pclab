<ul class="build-chooser-item-features">
    <li><span class="bold">Outputs:</span> {{ $component->present()->buildVideoOutputStr() }}</li>
    <li><span class="bold">SLI Support:</span> {{ $component->supports_sli ? 'Yes' : 'No' }}</li>
</ul>
