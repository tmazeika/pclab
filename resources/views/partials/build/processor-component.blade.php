<ul class="build-chooser-item-features">
    <li><span class="bold">Cores:</span> {{ $component->cores }}</li>
    <li><span class="bold">Speed:</span> {{ $component->speed / 1000.0 }} GHz</li>
    <li><span class="bold">Socket:</span> {{ $component->socket->name }}</li>
</ul>
