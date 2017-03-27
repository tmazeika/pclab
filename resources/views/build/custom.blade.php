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
<script>
    const ajaxSelectUrl = "{{ url('build/custom/select') }}";
    const csrfToken = "{{ csrf_token() }}";
</script>

<script src="{{ asset('js/app.js') }}"></script>
@endpush
