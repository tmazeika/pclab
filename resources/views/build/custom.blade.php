@extends('layouts.master')

@section('title', 'Custom Build')

@section('content')
<main class="content">
    <section>
        <h1 class="build-heading">Chassis</h1>
        <p class="build-desc">
            Your rig's shell and the first thing anybody sees. View the core of the machine through windowed side panels
            or take advantage of low-profile and quieter solid side-panels.
        </p>
        <div class="build-chooser">
            @foreach(PCForge\ChassisComponent::all() as $chassis)
            <div class="build-chooser-item">
                <img src="{{ $chassis->component->img() }}" width="300"/>
            </div>
            @endforeach
        </div>
    </section>

    <section>
        <h1 class="build-heading">Processor</h1>
        <p class="build-desc">
            The brain of the machine. Choose from one of the battle-tested Intel series or more budget-friendly AMD
            variations.
        </p>
    </section>

    <section>
        <h1 class="build-heading">Cooling</h1>
        <p class="build-desc">
            How the processor will be cooled. Keep costs down with air-only systems or opt for high-performing and
            silent closed-loop water cooling.
        </p>
    </section>

    <section>
        <h1 class="build-heading">Graphics</h1>
        <p class="build-desc">
            The pixel-pusher of your rig. Required for high-end gaming or video editing and rendering, but not necessary
            for general internet surfing or non-graphics intensive scenarios.
        </p>
    </section>

    <section>
        <h1 class="build-heading">Motherboard</h1>
        <p class="build-desc">
            The main board for connecting everything together and allowing various internal and external connections.
        </p>
    </section>

    <section>
        <h1 class="build-heading">Memory</h1>
        <p class="build-desc">
            The high-speed random access memory. At least 16 GB is recommended for gaming and other graphics intensive
            applications, but 8 GB should suffice in most other cases.
        </p>
    </section>

    <section>
        <h1 class="build-heading">Storage</h1>
        <p class="build-desc">
            The storage components for all your files, applications, and operating system(s). Choose from the lower
            capacity, ultra high speed solid-state drives or much higher capacity hard-disk drives.
        </p>
    </section>

    <section>
        <h1 class="build-heading">Power</h1>
        <p class="build-desc">
            The supply of power from the wall to all components. Modular power supplies eliminate unnecessary cable
            clutter, while non-modular power supplies may appeal to the more budget focused builder.
        </p>
    </section>
</main>
@endsection

@push('scripts')
@include('partials.js.jquery')
@endpush
