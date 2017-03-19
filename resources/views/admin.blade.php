@extends('layouts.master')

@section('title', 'Admin')

@section('content')
<main class="content">
    @each('partials.admin-tables', [
        '\PCForge\ChassisComponent',
        '\PCForge\ChassisFormFactor',
        '\PCForge\Component',
        '\PCForge\CoolingComponent',
        '\PCForge\CoolingSocket',
        '\PCForge\GraphicsComponent',
        '\PCForge\MemoryComponent',
        '\PCForge\MotherboardComponent',
        '\PCForge\PowerComponent',
        '\PCForge\ProcessorComponent',
        '\PCForge\StorageComponent',
    ], 'model')
</main>
@endsection
