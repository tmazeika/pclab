@extends('layouts.master')

@section('title', 'Admin')

@section('content')
<main class="content">
    @each('partials.admin.table', [
        'PCForge\ChassisComponent',
        'PCForge\ChassisComponentsFormFactor',
        'PCForge\ChassisComponentsRadiator',
        'PCForge\Component',
        'PCForge\CoolingComponent',
        'PCForge\CoolingComponentsSocket',
        'PCForge\FormFactor',
        'PCForge\GraphicsComponent',
        'PCForge\MemoryComponent',
        'PCForge\MotherboardComponent',
        'PCForge\PowerComponent',
        'PCForge\ProcessorComponent',
        'PCForge\Socket',
        'PCForge\StorageComponent',
        'PCForge\StorageSize',
    ], 'model')
</main>
@endsection
