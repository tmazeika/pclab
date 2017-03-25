@extends('layouts.master')

@section('title', 'Custom Build')

@section('content')
<main class="content">
    @each('partials.build.component', [
        'PCForge\ChassisComponent',
        'PCForge\ProcessorComponent',
        'PCForge\CoolingComponent',
        'PCForge\GraphicsComponent',
        'PCForge\MemoryComponent',
        'PCForge\MotherboardComponent',
        'PCForge\StorageComponent',
        'PCForge\PowerComponent',
    ], 'model')
</main>
@endsection

@push('scripts')
@include('partials.js.jquery')
@endpush
