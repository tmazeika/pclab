@extends('layouts.master')

@section('title', 'Admin')

@section('content')
<main class="content">
    @each('partials.admin.table', [
        'PCForge\ChassisComponent',
        'PCForge\ChassisComponentFormFactor',
        'PCForge\ChassisComponentsRadiator',
        'PCForge\Component',
        'PCForge\CoolingComponent',
        'PCForge\CoolingComponentSocket',
        'PCForge\FormFactor',
        'PCForge\GraphicsComponent',
        'PCForge\MemoryComponent',
        'PCForge\MotherboardComponent',
        'PCForge\PowerComponent',
        'PCForge\ProcessorComponent',
        'PCForge\Socket',
        'PCForge\StorageComponent',
        'PCForge\StorageWidth',
    ], 'model')
</main>
@endsection
