@extends('layouts.master')

@section('title', 'Admin')

@section('main')
    <main>
        @each('partials.admin.table', [
            \PCLab\Models\ChassisComponent::class,
            \PCLab\Models\ChassisComponentFormFactor::class,
            \PCLab\Models\RadiatorConfiguration::class,
            \PCLab\Models\Component::class,
            \PCLab\Models\ComponentType::class,
            \PCLab\Models\CoolingComponent::class,
            \PCLab\Models\CoolingComponentSocket::class,
            \PCLab\Models\FormFactor::class,
            \PCLab\Models\GraphicsComponent::class,
            \PCLab\Models\MemoryComponent::class,
            \PCLab\Models\MotherboardComponent::class,
            \PCLab\Models\PowerComponent::class,
            \PCLab\Models\ProcessorComponent::class,
            \PCLab\Models\Socket::class,
            \PCLab\Models\StorageComponent::class,
        ], 'model')
    </main>
@endsection
