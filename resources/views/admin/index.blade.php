@extends('layouts.master')

@section('title', 'Admin')

@section('content')
<main class="content">
    <a href="{{ url('admin/update-compatibilities') }}">
        [Update Compatibilities]
    </a>

    @each('partials.admin.table', [
        'PCForge\Models\ChassisComponent',
        'PCForge\Models\ChassisComponentFormFactor',
        'PCForge\Models\ChassisComponentsRadiator',
        'PCForge\Models\Compatibility',
        'PCForge\Models\Component',
        'PCForge\Models\ComponentType',
        'PCForge\Models\CoolingComponent',
        'PCForge\Models\CoolingComponentSocket',
        'PCForge\Models\FormFactor',
        'PCForge\Models\GraphicsComponent',
        'PCForge\Models\MemoryComponent',
        'PCForge\Models\MotherboardComponent',
        'PCForge\Models\PowerComponent',
        'PCForge\Models\ProcessorComponent',
        'PCForge\Models\Socket',
        'PCForge\Models\StorageComponent',
        'PCForge\Models\StorageWidth',
    ], 'model')
</main>
@endsection
