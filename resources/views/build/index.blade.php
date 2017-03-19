@extends('layouts.master')

@section('title', 'Build')

@section('content')
<main class="content">
    <section>
        <h1 class="build-heading">
            <a class="link" href="{{ url('build/custom') }}">Custom</a>
        </h1>
        <p class="build-desc">
            If you know exactly what parts you want, choose this route.
        </p>
    </section>

    <section>
        <h1 class="build-heading">
            <a class="link" href="{{ url('build/preset') }}">Preset</a>
        </h1>
        <p class="build-desc">
            If you're not sure what you want inside but you have a specific need, go here.
        </p>
    </section>
</main>
@endsection
