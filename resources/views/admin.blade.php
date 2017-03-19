@extends('layouts.master')

@section('title', 'Admin')

@section('content')
<main class="content">
    @each('partials.admin-tables', [
        \PCForge\ChassisComponent::all(),
        \PCForge\ChassisFormFactor::all(),
        \PCForge\Component::all(),
        \PCForge\CoolingComponent::all(),
        \PCForge\CoolingSocket::all(),
        \PCForge\GraphicsComponent::all(),
        \PCForge\MemoryComponent::all(),
        \PCForge\MotherboardComponent::all(),
        \PCForge\PowerComponent::all(),
        \PCForge\ProcessorComponent::all(),
        \PCForge\StorageComponent::all(),
    ], 'items')
</main>
@endsection
