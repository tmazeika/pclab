@extends('layouts.master')

@section('title', 'Admin')

@section('content')
    <main>
        @each('partials.admin.table', [
            \PCForge\Models\ChassisComponent::class,
            \PCForge\Models\ChassisComponentFormFactor::class,
            \PCForge\Models\ChassisComponentsRadiator::class,
            \PCForge\Models\Component::class,
            \PCForge\Models\ComponentType::class,
            \PCForge\Models\CoolingComponent::class,
            \PCForge\Models\CoolingComponentSocket::class,
            \PCForge\Models\FormFactor::class,
            \PCForge\Models\GraphicsComponent::class,
            \PCForge\Models\MemoryComponent::class,
            \PCForge\Models\MotherboardComponent::class,
            \PCForge\Models\PowerComponent::class,
            \PCForge\Models\ProcessorComponent::class,
            \PCForge\Models\Socket::class,
            \PCForge\Models\StorageComponent::class,
            \PCForge\Models\StorageWidth::class,
        ], 'model')
    </main>
@endsection
